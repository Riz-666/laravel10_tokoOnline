<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function berandaBackend(){
        return view('backend.v_beranda.index',[
            'user' => 'user',
            'judul' => 'Ini Beranda'
        ]);
    }
}
