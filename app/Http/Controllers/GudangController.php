<?php

namespace App\Http\Controllers;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Ramsey\Uuid\Uuid as Generate;
use App\Http\Controllers\HistoryController as History;

class GudangController extends Controller {
    

    public function index() {
        return view('gudang-bahan');
    }

    public function data() {
        $data = BahanBaku::orderBy('date_entry', 'desc');
        
        if (Auth::user()->roles == 1) { //kepala devisi
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
                                 
                                     return 'Data Kosong';
                               })
                               ->addColumn('Actions', function($data){
                                 return '<a href="javascript:;" class="btn btn-xs btn-info adding" data="'.$data->id.'">Tambah Stock</a>
                                 <a href="javascript:;" class="btn btn-xs btn-warning reduce" data="'.$data->id.'">Kurangi Stock</a>
                                 <a href="javascript:;" class="btn btn-xs btn-danger delete" data="'.$data->id.'">Hapus</a>
                                 ';
                               })                          
                               ->rawColumns(['Actions'])
                               ->toJson();
        } else if (Auth::user()->roles == 2) {
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
                                  
                                    return 'Data Kosong';
                              })
                              ->addColumn('Actions', function($data){
                                return '
                                <a href="javascript:;" class="btn btn-xs btn-warning reduce" data="'.$data->id.'">Kurangi Stock</a>
                                ';
                              })                          
                              ->rawColumns(['Actions'])
                              ->toJson();
        }

        
    }

    public function search(Request $req) {
        $data = BahanBaku::select($req->column)
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
            'id'    => Generate::uuid4(),
            'name'  => $req->name,
            'type'  => $req->type,
            'qty'   => $req->qty,
            'date_entry' => Date('Y-m-d H:i:s'),
        );

        try {
            DB::table('bahan_baku')->insert($data);

            History::create(
                "Penambahan Data Bahan Baku $req->name", 
                $req->type, 
                $req->qty
            );

            return response()->json(['success' => 'Berhasil Menambahkan Data Bahan Baku']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => 'Internal Server Error'], 500);
        }
    }

    public function addingStock($value, $id){
        try {
            date_default_timezone_set('Asia/Jakarta');     
            $data = BahanBaku::where('id', $id)->first();
            $stockNew = $data->qty + $value;

            DB::table('bahan_baku')->where('id', $id)->update([
                'date_entry' => Date('Y-m-d H:i:s'),
                'qty' => $stockNew
            ]);
            
            History::create(
                "Penambahan Pada : $data->name", 
                $data->type, 
                $value
            );

            return response()->json(['success' => 'Berhasil Menambahkan Stock Bahan Baku']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => 'Internal Server Error'], 500);
        }
    }


    public function reduceStock($value, $id){
        try {
            $data = BahanBaku::where('id', $id)->first();
            $stockNew = $data->qty - $value;

            DB::table('bahan_baku')->where('id', $id)->update([
                'date_out' => Date('Y-m-d H:i:s'),
                'qty' => $stockNew
            ]);

            History::create(
                "Pengurangan Pada : $data->name", 
                $data->type, 
                $value
            );
            return response()->json(['success' => 'Berhasil Mengurangi Stock Bahan Baku']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => 'Internal Server Error'], 500);
        }
    }

    public function destroy($id) {
        try {
            $data = BahanBaku::where('id', $id)->first();
            $data->delete();

            return response()->json(['success' => 'Berhasil Menghapus Data Gudang']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => 'Internal Server Error'], 500);
        }
    }
}
