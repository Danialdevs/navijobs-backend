<?php

namespace App\Http\Controllers;

use App\Models\Application;

class RequestsController extends Controller
{
    public function index()
    {
        $applications = Application::all();
        return view('Pages.requests.index', compact('applications'));
    }
}
