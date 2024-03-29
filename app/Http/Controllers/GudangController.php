<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\HistoryController as HistoryC;
use App\Models\Item;
use App\Models\Rack;
use App\Models\Type;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;

class GudangController extends Controller {
    

    public function index() {
        $listType = Type::select('id', 'name', 'code')->orderBy('created_at', 'desc')->get();
        $listUnit = Unit::select('id', 'name')->orderBy('created_at', 'desc')->get();
        $listRack = Rack::select('id', 'name')->orderBy('created_at', 'desc')->get();

        return view('gudang-bahan', compact('listType', 'listUnit', 'listRack'));
    }

    public function data() {
        $data = Item::with('type:id,name,code', 'unit:id,name', 'rack:id,name')->orderBy('date_entry', 'desc');
        
        if (Auth::user()->roles == '2') {
            return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->editColumn('date_entry', function ($data) {
                      return Carbon::createFromFormat('Y-m-d H:i:s', $data->date_entry, 'Asia/Jakarta')
                                     ->format('Y-m-d H:i:s');
                      })
                    ->editColumn('date_out', function ($data) {
                          if(!empty($data->date_out)){
                              return Carbon::createFromFormat('Y-m-d H:i:s', $data->date_out, 'Asia/Jakarta')
                              ->format('Y-m-d H:i:s');
                          }
                      
                          return ' - ';
                    })
                    ->addColumn('Actions', function($data) {
                         return '<a href="javascript:;" class="btn btn-xs btn-info adding" data="'.$data->id.'"><i class="fas fa-plus"></i></a>
                         <a href="javascript:;" class="btn btn-xs btn-warning reduce" data="'.$data->id.'"><i class="fas fa-minus"></i></a>
                         <a href="javascript:;" class="btn btn-xs btn-secondary edit" data="'.$data->id.'"><i class="far fa-edit"></i></a>
                         <a href="javascript:;" class="btn btn-xs btn-danger delete" data="'.$data->id.'"><i class="far fa-trash-alt"></i></a>
                         ';
                    })                          
                    ->rawColumns(['Actions'])
                    ->toJson();                 
        } else {
            return DataTables::eloquent($data)
                   ->addIndexColumn()
                   ->editColumn('date_entry', function ($data) {
                     return Carbon::createFromFormat('Y-m-d H:i:s', $data->date_entry, 'Asia/Jakarta')
                                    ->format('Y-m-d H:i:s');
                     })
                   ->editColumn('date_out', function ($data) {
                         if(!empty($data->date_out)){
                             return Carbon::createFromFormat('Y-m-d H:i:s', $data->date_out, 'Asia/Jakarta')
                             ->format('Y-m-d H:i:s');
                         }
                       
                         return ' - ';
                   })
                   ->rawColumns(['Actions'])
                   ->toJson();     
        }
        

    }

    public function search(Request $req) {
        $data = Item::select($req->column)
                         ->whereRaw("LOWER($req->column) LIKE ?", ["%".strtolower($req->keyword)."%"])
                         ->distinct()
                         ->get();

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req) {
        date_default_timezone_set('Asia/Jakarta');

        $data = array(
            'types_id' => $req->type,
            'units_id' => $req->unit,
            'rack_id' => $req->rak,
            'name'  => $req->name,
            'qty'   => $req->qty,
            'price' => $req->price,
            'total' => $req->qty * $req->price, 
            'date_entry' => Date('Y-m-d H:i:s')
        );

        try {
            
            $id = Item::insertGetId($data);
            Item::where('id', $id)->update(['item_code' => $req->type . $id]); 

            HistoryC::create(
                $id,
               'buy',
               "Pembelian Bahan Baku",
               $req->qty,
               $req->price,
               $req->qty * $req->price
            );

            return response()->json(['success' => 'Berhasil Menambahkan Data Bahan Baku']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => $th->errorInfo[2]]], 500);
        }
    }

    public function update($id, Request $req) {
        date_default_timezone_set('Asia/Jakarta');
        
        try {
            $qty = Item::select('qty')->where('id', $id)->first();

            $data = array(
                'types_id' => $req->type,
                'item_code' => $req->type . $id,
                'units_id' => $req->unit,
                'rack_id' => $req->rak,
                'name'  => $req->name,
                'price' => $req->price,
                'total' => $qty->qty * $req->price
            );
            
            Item::where('id', $id)->update($data);
            return response()->json(['success' => 'Berhasil Update Data Bahan Baku']);
        } catch (\Throwable $th) {
             return response()->json(['errors' => ['errors' => $th->errorInfo[2]]], 500);
        }
    }

    public function addingStock($value, $id) {
        //value = qty
        try {
            date_default_timezone_set('Asia/Jakarta');
            $data = Item::where('id', $id)->first();
            $stockNew = $data->qty + $value;
            $totalNew = $stockNew * $data->price;
            
            Item::where('id', $id)->update([
                'qty' => $stockNew,
                'total' => $totalNew
            ]);
            
            HistoryC::create(
                $id,
                'add', 
                "Penambahan Stock",
                $value,
                $data->price,
                $stockNew * $data->price
            );

            return response()->json(['success' => 'Berhasil Menambahkan Stock Bahan Baku']);
        } catch (\Throwable $th) {
              return response()->json(['errors' => ['errors' => $th->errorInfo[2]]], 500);
        }
    }


    public function reduceStock($value, $id){
        //value = qty
        try {
            date_default_timezone_set('Asia/Jakarta');
            $data = Item::where('id', $id)->first();
            $stockNew = $data->qty - $value;
            $totalNew = $stockNew * $data->price;
            
            DB::table('items')->where('id', $id)->update([
                'date_out' => Date('Y-m-d H:i:s'),
                'qty' => $stockNew,
                'total' => $totalNew
            ]);

            HistoryC::create(
                $id,
                'red', 
                "Pengurangan Stock", 
                $value,
                $data->price,
                $stockNew * $data->price
            );
            return response()->json(['success' => 'Berhasil Mengurangi Stock Bahan Baku']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => $th->errorInfo[2]]], 500);
        }
    }

    public function destroy($id) {
        try {
            $data = Item::where('id', $id)->first();
            $data->delete();

            return response()->json(['success' => 'Berhasil Menghapus Data Gudang']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => "Gagal Menghapus mohon dihapus terlebih dahulu data pada history"]], 500);
        }
    }

    //rollback adding / reduce
    public static function changedStockWithHistory($id, $act, $value) {
        try {
            $dataItem = Item::find($id);

            if ($act == 'add') {
                $qtyNew = $dataItem->qty - $value;
                $dataItem->qty = $qtyNew;
                $dataItem->total = $qtyNew * $dataItem->price;
                $dataItem->save();
                return true;
            } else if ($act == 'red') {
                $qtyNew = $dataItem->qty + $value;
                $dataItem->qty = $qtyNew;
                $dataItem->total = $qtyNew * $dataItem->price;
                $dataItem->save();
                return true;
            } else {
                return false;
            }

        } catch (\Throwable $th) {
            return false;
        }
    }

    //rollback buy
    public static function deleteWithHistory($id){
        
        try {
            Item::where('id', $id)->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
        
    }
}
