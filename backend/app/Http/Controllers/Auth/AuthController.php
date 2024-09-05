<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $staff = Staff::where('email', $credentials['email'])->first();

        if ($staff && Hash::check($credentials['password'], $staff->password_hash)) {
            $token = $staff->createToken('auth_token')->plainTextToken;
    
            return response()->json(['token' => $token], 200);
        }
    
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}