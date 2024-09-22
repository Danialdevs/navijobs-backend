<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Models\CompanyOffice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WorkersController extends Controller
{
    public function index()
    {
        if (Auth::user()->role != 'worker') {
            $users = User::query();
            $offices = CompanyOffice::query();
            if (Auth::user()->role === 'company_admin') {
                $users->where('company_office_id', Auth::user()->company_office_id)
                    ->whereHas('companyOffice', function ($query) {
                        $query->where('company_office_id', Auth::user()->companyOffice()->company_id);
                    });
                $offices->where('company_office_id', Auth::user()->companyOffice()->company_id);

            } elseif (Auth::user()->role === 'office_admin') {
                $users->where('company_office_id', Auth::user()->company_office_id);
            } elseif (Auth::user()->role === 'office_manager') {
                $users->where('company_office_id', Auth::user()->company_office_id)
                    ->where('role', 'worker');
            }

            $users = $users->get();
            $offices = $offices->get();

            return view('Pages.Workers.index', compact('users', 'offices'));
        } else {
            return Redirect::back();
        }

    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->all();




        User::create($data);

        return redirect()->back()->with('success', 'Worker added successfully');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('Pages.Workers.show', compact('user'));
    }
}
