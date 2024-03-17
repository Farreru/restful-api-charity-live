<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function register (Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'=>'required|string',
            'email'=>'required|string',
            'password'=>'required|string|min:8|confirmed',
        ]);

        if ($validate->fails()) {
            return $this->sendError('Validation error', $validate->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] = $user;

        return $this->sendResponse($data, 'User Berhasil Dibuat');

    }

    public function login (Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email'=>'required|string',
            'password'=>'required|string|min:8',
        ]);

        if ($validate->fails()) {
            return $this->sendError('Validation error', $validate->errors(), 422);
        }

        // Cek Email
        $user = User::where('email', $request->email)->first();

        // Cek Password
        if (!$user || !Hash::check($request->password, $user->password))
        {
            return $this->sendError("Email dan password salah!", 401);
        }

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] = $user;

        return $this->sendResponse($data, 'Login berhasil!');
    }

}
