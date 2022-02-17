<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid as Generate;

class HistoryController extends Controller {
    
    public function index() {
        return view('history');
    }

    public function data($params) {
        $data = History::with('item:id,name')->where('act', $params)->orderBy('created_at', 'desc');

        return DataTables::eloquent($data)
                            ->addIndexColumn()
                            ->editColumn('created_at', function ($data) {
                                return Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at, 'Asia/Jakarta')
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

    //revisi : tambahan tidak bisa didelet kalau tahun periodenya sama
    public function destroy(Request $req, $params){
        try {
            History::where('act', $params)
                    ->whereDate('created_at', "$req->year-$req->month-$req->day")
                    ->delete();
            
            return response()->json(['success' => 'Berhasil Menghapuskan Data History']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => 'Internal Server Error ' . $th], 500);
        }
    }
}
