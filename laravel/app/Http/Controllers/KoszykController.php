<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KoszykController extends Controller
{
    public function index()
    {

        return view('koszyk');
    }
}
