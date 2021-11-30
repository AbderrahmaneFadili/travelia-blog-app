<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //register user
    public function register(Request $request)
    {
        //validate user data
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        //create the user data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            "password" => Hash::make($request->password)
        ]);

        //create token
        $token = $user->createToken('travelia-blog-token')->plainTextToken;

        //create the response
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
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
        if (!$user || !Hash::check($request->password, $user->password)) {
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
