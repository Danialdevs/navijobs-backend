<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            $user = Auth::user();
            $token = $user->createToken('auth');
            return response()->json([
                "success" => true,
                "data" => [
                     'access_token' => $token->plainTextToken,
                    'user'=> $user
                ]
            ]);
        }

        return response()->json([
                "success" => false,
                "message" => "Unauthorized"
            ], 401);
    }


}
