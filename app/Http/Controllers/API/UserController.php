<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function test(){
        dd('here1');
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => Str::lower(request('email')), 'password' => request('password')])) {
            $user = Auth::user();
            $tokenResult = $user->createToken(config('app.name'));

            $result = [
                'access_token' => $tokenResult->accessToken,
                'token_type'   => 'Bearer',
                'expires_at'   => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
            ];

            return response()->json(
                [
                    "data" => $result,
                ]
            );
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json(
            [
                'data' => 'Successfully logged out',
            ]
        );
    }
}
