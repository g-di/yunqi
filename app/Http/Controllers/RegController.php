<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Http\Request;

class RegController extends Controller
{
    public function index()
    {
        $data = array();
        return view("reg/index", ['data' => $data]);
    }
}