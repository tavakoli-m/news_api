<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ApiResponse\Facades\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class GetMeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        return ApiResponse::withStatus(200)->withMessage('SignIn Successfuly')->withAppends([
            'result' => [
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'role' => (int)$user->is_admin === 0 ? 'USER' : 'ADMIN',
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s')
            ]
        ])->send();
    }
}
