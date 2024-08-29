<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\CreateUserRequest;
use App\Http\Requests\Api\Users\UpdateUserRequest;
use App\Models\Service;
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
    public function store(CreateUserRequest $request)
    {
        $user = $request->user();
        if($user->role === "company_admin" || $user->role === "office_admin"){
            $user = User::create($request->all());
        }
        return response()->json([
            'success' => true,
            'data' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $id)
    {
        $currentUser = $request->user();

        // Find the user by ID
        $user = User::findOrFail($id);

        // Check if the current user is authorized to view the user
        if ($currentUser->role === 'company_admin' && $currentUser->company_id === $user->company_id) {
            // Company admin can view any user within their company
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } elseif ($currentUser->role === 'office_admin' && $currentUser->office_id === $user->office_id) {
            // Office admin can view any user within their office
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } elseif ($currentUser->role === 'office_manager' && $currentUser->office_id === $user->office_id && $user->role === 'worker') {
            // Office manager can view workers within their office
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } else {
            // Unauthorized access
            return response()->json([
                'success' => false,
                'message' => "You don't have permission to view this user's profile."
            ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateUserRequest $request, int $id)
    {
        $currentUser = $request->user();
        $userToUpdate = User::findOrFail($id);

        if ($currentUser->role === 'company_admin') {
            // Company admin can update any user within their company
            $userToUpdate->update($request->all());
            return response()->json([
                'success' => true,
                'data' => $userToUpdate
            ]);
        } elseif ($currentUser->role === 'office_admin' && $userToUpdate->office_id === $currentUser->office_id) {
            // Office admin can update users within their office
            $userToUpdate->update($request->all());
            return response()->json([
                'success' => true,
                'data' => $userToUpdate
            ]);
        }

        // Office managers and workers or unauthorized office or company
        return response()->json([
            'success' => false,
            'message' => "You don't have permission to update this user's profile."
        ]);
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
