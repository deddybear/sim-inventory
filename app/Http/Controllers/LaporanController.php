<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Item;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index() {
        return view('laporan');
    }

    public function download($params, Request $req) {

        if ($params === "bbkeluar") {
            
            $history = History::with('item:id,name')
                            ->where('act', 'red')
                            ->whereMonth('created_at', $req->month)
                            ->whereYear('created_at', $req->year)
                            ->orderBy('created_at', 'asc')
                            ->get();

            $totalCome = collect($history)->sum('qty');

            $data = array(
                'histories' => $history,
                'total' => $totalCome,
                'title' => 'Bahan Baku Keluar'
            );

            return view('pdf/history', $data);

        } else if ($params === "bbmasuk") {

            $history = History::with('item:id,name')
                            ->where('act', 'add')
                            ->orWhere('act', 'buy')
                            ->whereMonth('created_at', $req->month)
                            ->whereYear('created_at', $req->year)
                            ->orderBy('created_at', 'asc')
                            ->get();

            $totalCome = collect($history)->sum('qty');

            $data = array(
                'histories' => $history,
                'total' => $totalCome,
                'title' => 'Bahan Baku Masuk'
            );

            return view('pdf/history', $data);

        } else if ($params === "bb") {

            $items = Item::with('type:id,name', 'unit:id,name')
                        ->whereMonth('date_entry', $req->month)
                        ->whereYear('date_entry', $req->year)
                        ->orderBy('date_entry', 'asc')
                        ->get();

            $totalExp = collect($items)->sum('total');

            $data = array(
                'items'     => $items,
                'total_exp' => $totalExp
            );

            return view('pdf/items', $data);

        } else {
            return "404";
        }
        
    }
}
