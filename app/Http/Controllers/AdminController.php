<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class AdminController extends Controller
{
    public function home() {
        return view('panel.index');
    }
}