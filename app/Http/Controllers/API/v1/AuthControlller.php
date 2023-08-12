<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\LoginRequest;
use App\Http\Requests\API\v1\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthControlller extends Controller
{

    public function login(LoginRequest $request)
    {

        if (Auth::attempt($request->validated())) {
           $user = auth()->user();
           $user['token'] = $user->authToken;
           return $this->successResponse($user);
        }

        return $this->errorResponse(message:'Invalid Credentials',code:200);
    }


    public function register(RegisterRequest $request)
    {
        
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        $user['token'] = $user->auth_token;
        
        return $this->successResponse(data:$user);
    
    }

}
