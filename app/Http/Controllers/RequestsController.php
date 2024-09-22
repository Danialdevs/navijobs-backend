<?php

namespace App\Http\Controllers;

class RequestsController extends Controller
{
    public function index()
    {
        return view('Pages.requests.index');
    }
}
