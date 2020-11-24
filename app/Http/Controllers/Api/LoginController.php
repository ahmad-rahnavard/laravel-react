<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Login user and create token
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!auth()->attempt(request(['email', 'password']))) {
            return Response::error('Invalid credentials!', [], 401);
        }

        $tokenResult = auth()->user()->createToken('Personal Access Token');
        $token       = $tokenResult->token;

        if (request('remember_me')) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return Response::success('success!', [
            'user'         => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email
            ],
            'access_token' => [
                'token'      => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ]
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->user()->token()->revoke();

        return Response::success('Successfully logged out');
    }
}
