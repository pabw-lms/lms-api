<?php

namespace App\Http\Controllers\Api\V1;

use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index() {
        return User::where('role', '!=', 'admin')->get();
    }

    public function show($id) {
        return User::where('id', $id)->get();
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['token' => $token, 'message' => 'Registration success'], 201);
    }

    // public function register(Request $request) {

    //     $field = $request->validate([
    //         'name' => 'string|required',
    //         'email' => 'string|required|unique:users,email',
    //         'password' => 'string|required|confirmed'
    //     ]);

    //     // // var_dump($field);

    //     $user = User::create([
    //         'name' => $field['name'],
    //         'email' => $field['email'],
    //         'password' => bcrypt($field['password'])
    //     ]);

    //     // $token = $request->user()->createToken($request->token_name);

    //     // // // return ['token' => $token->plainTextToken];
    //     $token = $user->createToken('mytoken')->plainTextToken;

    //     $response = [
    //         'user' => $user,
    //         'token' => $token,
    //     ];

    //     return response($response, 201);
    //     // return Hash::make($field['password']);
    // }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // $user = Auth::user();
            // $token = $user->createToken('api_token')->plainTextToken;
            // return response()->json(['token' => $token], 200);
            $user = Auth::user();
            return response()->json(['user' => $user->id], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // public function login(Request $request) {

    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         $user = Auth::user();
    //         $success['token'] = $user->createToken('auth_token')->plainTextToken;
    //         $success['name'] = $user->name;
    //         return response()->json([
    //             'message' => 'Login success',
    //             'data' => $user
    //         ]);
    //     } else {
    //         return response()->json([
    //             'message' => 'Login failed',
    //         ]);
    //     }
    //     // $field = $request->validate([
    //     //     'email' => 'string|required',
    //     //     'password' => 'string|required'
    //     // ]);

    //     // // check email
    //     // $user = User::where('email', $field['email'])->first();

    //     // // $hash = bcrypt($field['password']);
    //     // // echo $hash;
    //     // // var_dump($user->email);
    //     // // var_dump(Hash:: $user->password);
    //     // // var_dump(Hash::make($field['password']));

    //     // // $password = bcrypt($field['password']);

    //     // // check password
    //     // if(!$user || !$field['password'] == $user->password) {
    //     //     return response([
    //     //         'message' => 'email or password is wrong'
    //     //     ], 401);
    //     // }

    //     // // if(Hash::check($field['password'], $user->password)) {
    //     // //     echo 'yes';
    //     // // } else {
    //     // //     echo 'no';
    //     // // }


    //     // // $token = $user->createToken('token')->plainTextToken;

    //     // // $response = [
    //     // //     'user' => $user,
    //     // //     'token' => $token,
    //     // // ];

    //     // return response($response, 201);
    // }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }

    // public function logout(Request $request) {
    //     // auth()->user()->tokens()->delete();

    //     // return ['message' => 'Logged out'];
    // }
}
