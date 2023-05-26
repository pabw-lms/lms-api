<?php

namespace App\Http\Controllers\Api\V1;

use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $field = $request->validate([
            'name' => 'string|required',
            'email' => 'string|required|unique:users,email',
            'password' => 'string|required|confirmed'
        ]);

        $user = User::create([
            'name' => $field['name'],
            'email' => $field['email'],
            'password' => bcrypt($field['password'])
        ]);

        // $token = $request->user()->createToken($request->token_name);

        // return ['token' => $token->plainTextToken];
        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $field = $request->validate([
            'email' => 'string|required',
            'password' => 'string|required'
        ]);

        // check email
        $user = User::where('email', $field['email'])->first();

        // check password
        if(!$user || !Hash::check($field['password'], $user->password)) {
            return response([
                'message' => 'email or password is wrong'
            ], 401);
        }


        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return ['message' => 'Logged out'];
    }
}
