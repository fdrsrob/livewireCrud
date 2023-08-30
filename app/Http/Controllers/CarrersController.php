<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarrersController extends Controller
{
    public function index()
    {
        return view('wolf.index');
    }
}
