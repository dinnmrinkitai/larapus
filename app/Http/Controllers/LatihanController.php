<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LatihanController extends Controller
{
    //
    public function __construct()
    {
    	//Midddleware untuk semua method
    	$this->midddleware('auth');
    }
    public function index()
    {
        return view('index');
    }

}
