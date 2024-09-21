<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Workers\CreateWorkerRequest;
use App\Models\CompanyOffice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WorkersController extends Controller
{
    public function index()
    {
         if (Auth::user()->role != 'worker') {
    $users = User::query();

    if (Auth::user()->role === 'company_admin' || Auth::user()->role === 'office_admin') {
        $users->where('office_id', Auth::user()->office_id);
    } elseif (Auth::user()->role === 'office_manager') {
        $users->where('office_id', Auth::user()->office_id)
              ->where('role', 'worker');
    }

    $users = $users->get();

    return view('Pages.Workers.index', compact('users'));
} else {
    return Redirect::back();
}


    }
    public function store(CreateUserRequest $request){
        User::create($request->all());
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('Pages.Workers.show', compact('user'));
    }
}
