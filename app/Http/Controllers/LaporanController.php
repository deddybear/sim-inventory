<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index() {
        return view('laporan');
    }

    public function laporanDivisi(Request $req){
        $data = History::select('name');
    }
}
