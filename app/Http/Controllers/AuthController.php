<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $Request){
        $field = $request->validate([
            'name' => 'required|string', 
            'email' => 'required|string|unique:user,email', 
            'password' => 'required|string|confirmed'
        ]);
        $user = User :: create([
            'name' => $fields['name'], 
            'email' => $fields['email'], 
            'password' => bcrypt($fields['password']), 
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response =[
            'user' => $user, 
            'token' => $token 
        ];
        return response($response, 201);
    }


    public function login(Request $Request){
        $field = $request->validate([
            'email' => 'required|string', 
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response =[
            'user' => $user, 
            'token' => $token 
        ];
        return response($response, 201);
    }

    public function logout(Request $Request){
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
