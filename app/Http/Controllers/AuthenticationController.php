<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserFormRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)) return response()->json(['message' => 'Unauthorized'], 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) $token->expires_at = Carbon::now()->addMonths(1);

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function check()
    {
        $message = true;

        if (!Auth::check()) {
            $message = false;
        }

        return response()->json([
            'message' => $message
        ], 200);
    }
}
