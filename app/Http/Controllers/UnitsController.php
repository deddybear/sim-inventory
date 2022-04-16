<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Ramsey\Uuid\Uuid as Generate;

class UnitsController extends Controller {
    //

    public function index(){
        return view('units-bahan-baku');
    }

    public function data(){
        $data = Unit::orderBy('created_at', 'desc');

        return DataTables::eloquent($data)
                                ->addIndexColumn()
                                ->editColumn('created_at', function ($data) {
                                  return Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at, 'Asia/Jakarta')
                                                 ->format('Y-m-d H:i:s');
                                  })
                                ->editColumn('updated_at', function ($data) { 
                                    return Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at, 'Asia/Jakarta')
                                    ->format('Y-m-d H:i:s');
                                })
                                ->addColumn('Actions', function($data){
                                  return '
                                  <a href="javascript:;" class="btn btn-xs btn-warning edit" data="'.$data->id.'"><i class="far fa-edit"></i></a>
                                  <a href="javascript:;" class="btn btn-xs btn-danger delete" data="'.$data->id.'"><i class="far fa-trash-alt"></i></a>
                                  ';
                                })                          
                                ->rawColumns(['Actions'])
                                ->toJson(); 
    }

    public function search(Request $req) {
        $data = Unit::select($req->column)
                         ->whereRaw("LOWER($req->column) LIKE ?", ["%".strtolower($req->keyword)."%"])
                         ->distinct()
                         ->get();

        return $data;
    }

    public function create(Request $req){
        date_default_timezone_set('Asia/Jakarta');

        $data = array(
            'id' => Generate::uuid4(),
            'name' => $req->name,
        );

        try {     
            Unit::create($data);
            return response()->json(['success' => 'Berhasil Menambahkan Data Jenis Bahan Baku']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => 'Internal Server Error']], 500);
        }
    }
    
    public function update($id, Request $req){
        
        $data = array(
            'id' => Generate::uuid4(),
            'name' => $req->name,
        );

        try {
            Unit::where('id', $id)->update($data);
            return response()->json(['success' => 'Berhasil Memperbarui Data Jenis Bahan Baku']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => 'Internal Server Error']], 500);
        }
    }
    
    public function destroy($id){
        try {
            Unit::where('id', $id)->delete();
            return response()->json(['success' => 'Berhasil Menghapus Data Jenis Bahan Haku']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => 'Internal Server Error']], 500);
        }
    }
}
