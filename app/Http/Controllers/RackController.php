<?php

namespace App\Http\Controllers;

use App\Models\Rack;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid as Generate;

class RackController extends Controller {
    
    public function index() {
        return view('data-rack');
    }
    
    public function data(){
        $data = Rack::orderBy('created_at', 'desc');

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
        $data = Rack::select($req->column)
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
            Rack::create($data);
            return response()->json(['success' => 'Berhasil Menambahkan Data Jenis Bahan Baku']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => $th->errorInfo[2]]], 500);
        }
    }

    public function update($id, Request $req){
        $data = array(
            'id' => Generate::uuid4(),
            'name' => $req->name,
        );

        try {
            Rack::where('id', $id)->update($data);
            return response()->json(['success' => 'Berhasil Memperbarui Data Jenis Bahan Baku']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => $th->errorInfo[2]]], 500);
        }
    }

    public function destroy($id){
        try {
            Rack::where('id', $id)->delete();
            return response()->json(['success' => 'Berhasil Menghapus Data Jenis Bahan Haku']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => $th->errorInfo[2]]], 500);
        }
    }
}
