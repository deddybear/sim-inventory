<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid as Generate;

class HistoryController extends Controller {
    
    public function index() {
        return view('history');
    }

    public function data($params) {

        if ($params == 'add') {

            $data = History::with('item:id,name')
                            ->where('act', $params)
                            ->orWhere('act', 'buy')
                            ->orderBy('created_at', 'desc');
        } else {

            $data = History::with('item:id,name')
                            ->where('act', $params)
                            ->orderBy('created_at', 'desc');
        }

       

        return DataTables::eloquent($data)
                            ->addIndexColumn()
                            ->editColumn('created_at', function ($data) {
                                return Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at, 'Asia/Jakarta')
                                ->format('Y-m-d H:i:s');
                            })
                            ->addColumn('Actions', function($data){
                                return "<a href='javascript:;' class='btn btn-xs btn-success delete' 
                                data='$data->id' data-desc='$data->descr' 
                                data-act='$data->act' data-qty='$data->qty'
                                data-name=".$data->item->name.">
                                <i class='fas fa-undo'></i>
                                </a>";
                            })
                            ->rawColumns(['Actions'])
                            ->toJson();
    }

    public function search(Request $req) {
        $data = History::select($req->column)
                         ->whereRaw("LOWER($req->column) LIKE ?", ["%".strtolower($req->keyword)."%"])
                         ->distinct()
                         ->get();

        return $data;
    }

    static public function create($items_id, $act, $desc, $qty) {      
        try {
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'id'    => Generate::uuid4(),
                'items_id' => $items_id,
                'act'  => $act,
                'descr'  => $desc,
                'qty'   => $qty,
                'created_at' => Date('Y-m-d H:i:s')
            );

            History::create($data);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function rollback($id, Request $req) {

        try {
            if ($req->act == 'buy') {
                $dataHistory = History::where('id', $id)
                               ->where('act', $req->act)
                               ->first();
                $idItem      = $dataHistory->items_id;
                $dataHistory->delete();

                Item::find($idItem)->delete();
                return response()->json(['success' => 'Berhasil, Merollback']);

            } else if ($req->act == 'add') {

                $dataHistory = History::where('id', $id)
                               ->where('act', $req->act)
                               ->first();

                $idItem      = $dataHistory->items_id;
                $dataHistory->delete();

                $dataItem = Item::find($idItem)->first();
                $stockNew = $dataItem->qty - $req->qty;
                Item::find($idItem)->update([
                    'qty' => $stockNew
                ]);

                return response()->json(['success' => 'Berhasil, Merollback']);
            } else if ($req->act == 'red') {

                $dataHistory = History::where('id', $id)
                               ->where('act', $req->act)
                               ->first();

                $idItem      = $dataHistory->items_id;
                $dataHistory->delete();

                $dataItem = Item::find($idItem)->first();
                $stockNew = $dataItem->qty + $req->qty;
                Item::find($idItem)->update([
                    'qty' => $stockNew
                ]);
                return response()->json(['success' => 'Berhasil, Merollback']);
            } else {
                return response()->json(['errors' => ['errors' => 'Type Aksi Tidak diketahui']], 500);
            }
         
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => 'Internal Server Error']], 500);
        }
    }

    //revisi : tambahan tidak bisa didelet kalau tahun periodenya sama
    public function destroy(Request $req, $params) {
        date_default_timezone_set('Asia/Jakarta');
        
        $yearNow = Date('Y');

        if ($req->year >= $yearNow) {
            return response()->json(['errors' => ['errors' => 'Periode Tahun Tidak Boleh Sama atau melebihi']], 400);
        }

        try {
            DB::table('histories')
                ->where('act', $params)
                ->whereMonth('created_at', $req->month)
                ->whereYear('created_at', $req->year)
                ->delete();
                
            return response()->json(['success' => 'Berhasil Menghapuskan Data History']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => 'Internal Server Error']], 500);
        }
    }
}
