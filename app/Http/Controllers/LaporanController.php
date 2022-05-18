<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidationLaporan;
use App\Models\History;
use App\Models\Item;
use Barryvdh\DomPDF\Facade as PDF;

class LaporanController extends Controller
{
    public function index() {
        return view('laporan');
    }

    public function download($params, ValidationLaporan $req) {

        if ($params === "bbkeluar") {
            
            $history = History::with('item:id,name,price')
                            ->where('act', 'red')
                            ->whereMonth('created_at', $req->month)
                            ->whereYear('created_at', $req->year)
                            ->orderBy('created_at', 'asc')
                            ->get();

            $totalQty = collect($history)->sum('qty');
            $totalCost = collect($history)->sum('total');
          
            $data = array(
                'histories' => $history,
                'total_qty' => $totalQty,
                'total_price' => $totalCost,
                'title' => 'Bahan Baku Keluar',
                'status' => 'Pengeluaran Harga Bahan Baku'
            );

      
            $pdf = PDF::loadView('pdf.history', $data)->setPaper('A4', 'potrait');
            return $pdf->stream();


        } else if ($params === "bbmasuk") {

            $history = History::with('item:id,name,price')
                            ->where('act', 'add')
                            ->orWhere('act', 'buy')
                            ->whereMonth('created_at', $req->month)
                            ->whereYear('created_at', $req->year)
                            ->orderBy('created_at', 'asc')
                            ->get();

            $totalQty = collect($history)->sum('qty');
            $totalCost = collect($history)->sum('total');

            $data = array(
                'histories' => $history,
                'total_qty' => $totalQty,
                'total_price' => $totalCost,
                'title' => 'Bahan Baku Masuk',
                'status' => 'Pemasukan Harga Bahan Baku'
            );

    
            $pdf = PDF::loadView('pdf.history', $data)->setPaper('A4', 'potrait');
            return $pdf->stream();

        } else if ($params === "bb") {

            $items = Item::with('type:id,name', 'unit:id,name')
                        ->whereMonth('date_entry', $req->month)
                        ->whereYear('date_entry', $req->year)
                        ->orderBy('date_entry', 'asc')
                        ->get();

            $qty = collect($items)->sum('qty');
            $totalExp = collect($items)->sum('total');

            $data = array(
                'items'     => $items,
                'total_exp' => $totalExp,
                'total_qty' => $qty
            );

            $pdf = PDF::loadView('pdf.items', $data)->setPaper('A4', 'potrait');
            return $pdf->stream();

        } else {
            return "404";
        }
        
    }
}
