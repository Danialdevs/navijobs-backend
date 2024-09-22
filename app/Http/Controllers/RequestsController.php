<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestsController extends Controller
{
    function index(){
        return view('Pages.requests.index');
    }
}
