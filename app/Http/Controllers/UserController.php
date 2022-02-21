<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidationUser;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    

    public function index() {
        return view('data-karyawan');
    }

    public function pageEditAkun() {
        return view('auth/register');
    }

    public function data(){
        $data = User::orderBy('created_at', 'desc');

        return DataTables::eloquent($data)
                            ->addIndexColumn()
                            ->editColumn('roles', function ($data) {
                                return ($data->roles == '1') ? 'Spv Gudang': 'Operator Gudang';
                            })
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
                                <a href="javascript:;" class="btn btn-xs btn-danger delete" data="'.$data->id.'"><i class="far fa-trash-alt"></i></a>
                                ';
                            })                          
                            ->rawColumns(['Actions'])
                            ->toJson(); 
    }

    public function search(Request $req){
        $data = User::select($req->column)
                        ->whereRaw("LOWER($req->column) LIKE ?", ["%".strtolower($req->keyword)."%"])
                        ->distinct()
                        ->get();

        return $data;
    }

    public function create(ValidationUser $req){

       $data = array(
            "id"    => Uuid::uuid4(),
            "roles" => $req->roles,
            "name"  => $req->name,
            "password" => Hash::make($req->password),
            "email" => $req->email,
       );

       try {
            User::create($data);
            return response()->json(['success' => 'Berhasil Menambahkan Data Karyawan']);
       } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => 'Internal Server Error']], 500);
       }
    }

    public function update($id, ValidationUser $req) {

       $data = array(
            "roles" => $req->roles,
            "name"  => $req->name,
            "password" => Hash::make($req->password),
            "email" => $req->email,
       );

       try {
            User::where('id', $id)->update($data);
            return response()->json(['success' => 'Berhasil Update Data Karyawan']);
       } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => 'Internal Server Error']], 500);
       }
    }

    public function destroy($id){
        try {
            User::where('id', $id)->delete();
            return response()->json(['success' => 'Berhasil Menghapus Data Karyawan']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['errors' => 'Internal Server Error']], 500);
        }
    }
}
