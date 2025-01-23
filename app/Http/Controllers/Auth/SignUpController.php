<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use App\Models\User;
use App\Services\ApiResponse\Facades\ApiResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SignUpRequest $request)
    {
        $clientData = $request->validated();

        $clientData['password'] = Hash::make($clientData['password']);

        $user = User::create($clientData);

        $token = $user->createToken('API TOKEN')->plainTextToken;

        $auth_cookie = cookie('auth_cookie', Crypt::encryptString($token), 60 * 12 * 7);

        return ApiResponse::withStatus(200)->withMessage('SignUp Successfuly')->withAppends([
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
