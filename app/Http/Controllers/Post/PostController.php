<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\PostListApiResource;
use App\Models\Post;
use App\Services\ApiResponse\Facades\ApiResponse;
use App\Services\Image\ImageService;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        return ApiResponse::withStatus(200)->withAppends(['result' => PostListApiResource::collection($posts)])->send();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, ImageService $imageService)
    {
        $clientData = $request->validated();

        $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'posts');
        $result = $imageService->createIndexAndSave($request->file('image'));
        if ($result === false) {
            return ApiResponse::withStatus(500)->withData(['result' => false])->withMessage('An error occurred while uploading the image.')->send();
        }
        $clientData['image'] = $result;

        $clientData['user_id'] = Auth::id();


        $post = Post::create($clientData);

        return ApiResponse::withStatus(200)->withAppends(['result' => new PostListApiResource($post)])->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return ApiResponse::withStatus(200)->withAppends(['result' => new PostListApiResource($post)])->send();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post, ImageService $imageService)
    {
        $clientData = $request->validated();

        if ($request->hasFile('image')) {
            if (!empty($post->image)) {
                $imageService->deleteDirectoryAndFiles($post->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'posts');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return ApiResponse::withStatus(500)->withData(['result' => false])->withMessage('An error occurred while uploading the image.')->send();
            }
            $clientData['image'] = $result;
        }

        $updateResult = $post->update($clientData);

        return ApiResponse::withStatus(status: 200)->withData(['result' => $updateResult])->send();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post,ImageService $imageService)
    {
        if (!empty($post->image)) {
            $imageService->deleteDirectoryAndFiles($post->image['directory']);
        }

        $deleteResult = $post->delete();

        return ApiResponse::withStatus(status: 200)->withData(['result' => $deleteResult])->send();
    }


    public function toggleSelected(Post $post)
    {
        if ($post->is_editor_selected === 1) {
            $result = $post->update(['is_editor_selected' => 0]);
        } else {
            $result = $post->update(['is_editor_selected' => 1]);
        }

        return ApiResponse::withStatus(200)->withData(['result' => $result])->send();
    }

    public function toggleBreakingNews(Post $post)
    {
        if ($post->is_breaking_news === 1) {
            $result = $post->update(['is_breaking_news' => 0]);
        } else {
            $result = $post->update(['is_breaking_news' => 1]);
        }

        return ApiResponse::withStatus(200)->withData(['result' => $result])->send();
    }
}
