<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentListApiResource;
use App\Models\Comment;
use App\Services\ApiResponse\Facades\ApiResponse;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();

        return ApiResponse::withStatus(200)->withAppends(['result' => CommentListApiResource::collection($comments)])->send();
    }

    public function toggleStatus(Comment $comment)
    {
        if ((int)$comment->status === 1) {
            $result = $comment->update(['status' => 0]);
        } else {
            $result = $comment->update(['status' => 1]);
        }

        return ApiResponse::withStatus(200)->withData(['result' => $result])->send();
    }
}
