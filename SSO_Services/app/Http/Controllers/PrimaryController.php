<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\SharedEncrypt;
use Illuminate\Support\Facades\Auth;

class PrimaryController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }
}
