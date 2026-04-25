<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
   public function showLoginForm()
    {
        return view('auth.log_in');
    }
    
   public function showSinginForm()
    {
        return view('auth.sing_in');
    }
}
