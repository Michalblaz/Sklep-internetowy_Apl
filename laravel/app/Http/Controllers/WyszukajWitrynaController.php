<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class WyszukajWitrynaController extends Controller{

    public function PrzeniesNaStrone(){


    return view("Strona_Wyszukiwania");

    }

}
