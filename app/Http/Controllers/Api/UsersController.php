<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->user()->role != 'worker'){
            $users = User::query();
            if($request->user()->role === 'company_admin'){
                $users->where('company_id', $request->user()->company_id);
            }
            elseif ($request->user()->role === 'office_admin'){
                $users->where('office_id', $request->user()->office_id);
            }
            elseif ($request->user()->role === 'office_manager'){
                $users->where('office_id', $request->user()->office_id)->where('role','worker');
            }

            return response()->json([
                'success' => true,
                'data' => $users->get()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You can\'t access this page'
            ]);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($request->user()->role === "company_admin"){
            if($user->company_id === $request->user()->company_id){
                $user->destroy();
            }
        }elseif ($request->user()->role === "office_admin"){
            if($user->office_id === $request->user()->office_id){
                $user->destroy();
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'You can\'t access this page'
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "The user was successfully deleted!"
        ]);

    }
}
