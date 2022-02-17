<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index() {
        return view('laporan');
    }

    public function downloadLaporan(Request $req) {

        if ($req->type === "bbkeluar") {
            
            $data = History::with('item:id,name')
                            ->where('act', 'red')
                            ->whereMonth('created_at', $req->month)
                            ->whereYear('created_at', $req->year)
                            ->orderBy('created_at', 'asc')
                            ->get();

        } else if ($req->type === "bbmasuk") {

        } else if ($req->type === "bb") {

        }
        
    }
}
