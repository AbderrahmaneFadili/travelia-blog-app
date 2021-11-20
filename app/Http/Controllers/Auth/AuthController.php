<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //register user
    public function register(Request $request)
    {
        //validate user data
        $this->validate($request, [
            "name" => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|confirmed'
        ]);

        //create the user data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            "password" => $request->password
        ]);

        //create token
        $token = $user->createToken('travelia-blog-token')->plainTextToken;

        //create the response
        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    //login user
    public function login(Request $request)
    {
        //validate data
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        //check user email
        $user = User::where('email', 'like', $request->email)->first();

        //check if the user is not exist or the passowrds is not matched. 
        if (!$user || Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Invalid login'
            ], 401);
        }

        //create token
        $token = $user->createToken('travelia-blog-token')->plainTextToken;

        //create response
        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    //logout 
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'logout',
        ];
    }
}
