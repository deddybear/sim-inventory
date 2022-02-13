<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }

    public function dataPemasukanGudang() {
        # code...
    }

    public function dataPengeluaranGudang() {
        # code...
    }

    public function dataPemasukanBahanBaku() {
        # code...
    }

    public function dataPengeluaranBahanBaku() {
        # code...
    }

    public function index() {
        return view('home');
    }

}
