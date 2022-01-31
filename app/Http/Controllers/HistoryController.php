<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid as Generate;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller {
    
    public function index() {
        return view('history');
    }

    public function data(){
        $data = History::orderBy('date_time', 'desc');

        return DataTables::eloquent($data)
                            ->addIndexColumn()
                            ->editColumn('date_time', function ($data) {
                                return Carbon::createFromFormat('Y-m-d H:i:s', $data->date_time, 'Asia/Jakarta')
                                ->format('Y-m-d H:i:s');
                            })
                            ->toJson();
    }

    public function search(Request $req) {
        $data = History::select($req->column)
                         ->whereRaw("LOWER($req->column) LIKE ?", ["%".strtolower($req->keyword)."%"])
                         ->distinct()
                         ->get();

        return $data;
    }

    static public function create($name, $type, $qty) {      
        try {
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'id'    => Generate::uuid4(),
                'name'  => $name,
                'type'  => $type,
                'qty'   => $qty,
                'date_time' => Date('Y-m-d H:i:s')
            );
            DB::table('history')->insert($data);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function destroy(Request $req){
        try {
            History::whereDate('date_time', "$req->year-$req->month-$req-$req->day")->delete();
            return response()->json(['success' => 'Berhasil Menghapuskan Data Periode']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => 'Internal Server Error ' . $th], 500);
        }
    }
}
