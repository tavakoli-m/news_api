<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserListApiResource;
use App\Models\User;
use App\Services\ApiResponse\Facades\ApiResponse;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return ApiResponse::withStatus(200)->withAppends(['result' => UserListApiResource::collection($users)])->send();
    }

    public function toggleRole(User $user)
    {
        if ((int)$user->is_admin === 1) {
            $result = $user->update(['is_admin' => 0]);
        } else {
            $result = $user->update(['is_admin' => 1]);
        }

        return ApiResponse::withStatus(200)->withData(['result' => $result])->send();
    }
}
