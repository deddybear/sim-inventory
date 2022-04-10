<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Type;

class HomeController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('home');
    }

    public function dataBarIncomeOutcome($year, $act) {

        try {
            if ($act == 'out') {

                $data = History::select(
                            DB::raw("(DATE_FORMAT(created_at, '%m')) as month"),
                            DB::raw("(sum(qty)) as total")
                        )
                        ->where('act', 'red')
                        ->whereYear('created_at', $year)
                        ->orderBy('month')
                        ->groupBy(
                            DB::raw("DATE_FORMAT(created_at, '%m')")
                        )
                        ->get();
            } else if ($act == 'inc') {
    
                $data = History::select(
                            DB::raw("(sum(qty)) as total"),
                            DB::raw("(DATE_FORMAT(created_at, '%m')) as month"),
                        )
                        ->where('act', 'add')
                        ->orWhere('act', 'buy')
                        ->whereYear('created_at', $year)
                        ->orderBy('month')
                        ->groupBy(
                            DB::raw("DATE_FORMAT(created_at, '%m')")
                        )
                        ->get();
             
            } else {
                return response()->json(['error' => "Kategori tidak ditemukan"], 500);
            }
            
            $data = $this->push($data);

            return response()->json($data);

        } catch (\Throwable $th) {

            return response()->json(['error' => $th], 500);
        }
    }

    public function dataPieIncomeOutcome($year, $act) {

        
        try {
            
            if ($act == 'out') {
                $data = History::select('types.name', DB::raw('sum(histories.qty) as qty'))
                                ->leftJoin('items', 'items.id', '=', 'histories.items_id')
                                ->leftJoin('types', 'types.id', '=', 'items.types_id')
                                ->where('histories.act', 'red')
                                ->whereYear('histories.created_at', $year)
                                ->orderBy('types.id', 'desc')
                                ->groupBy('types.id')
                                ->get();

            } else if ($act == 'inc'){
                $data = History::select('types.name', DB::raw('sum(histories.qty) as qty'))
                                ->leftJoin('items', 'items.id', '=', 'histories.items_id')
                                ->leftJoin('types', 'types.id', '=', 'items.types_id')
                                ->where('histories.act', 'add')
                                ->orWhere('histories.act', 'buy')
                                ->whereYear('histories.created_at', $year)
                                ->groupBy('types.id')
                                ->orderBy('types.id', 'desc')
                                ->get();

            } else {
                return response()->json(['error' => "Kategori tidak ditemukan"], 500);
            }

            foreach ($data as $key => $value) {
                $array[$key] = $value->qty;
            }

            return response()->json($array);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 500);
        }
    }

    public function push($data) {
        $array = array();
        
        foreach ($data as $key => $value) {
            $array[Carbon::create()->month($value->month)->format('F')] = $value->total;
        }

        return $array;
    }

    public function listMaterial(){
        return Type::select('name')->orderBy('types.id', 'desc')->get();
    }
}
