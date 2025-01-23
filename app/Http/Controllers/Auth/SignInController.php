<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;
use App\Services\ApiResponse\Facades\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SignInController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SignInRequest $request)
    {
        $clientData = $request->validated();

        $signInResult = Auth::attempt($clientData);

        if(!$signInResult){
            return ApiResponse::withStatus(401)->withMessage('Client Data Is Not Valid !!');
        }

        $user = Auth::user();


        $token = $user->createToken('API TOKEN')->plainTextToken;

        $auth_cookie = cookie('auth_cookie', Crypt::encryptString($token), 60 * 12 * 7);

        return ApiResponse::withStatus(200)->withMessage('SignIn Successfuly')->withAppends([
            'result' => [
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'role' => (int)$user->is_admin === 0 ? 'USER' : 'ADMIN',
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s')
            ]
        ])->send()->cookie($auth_cookie);
    }
}
