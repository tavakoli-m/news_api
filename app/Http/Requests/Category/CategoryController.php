<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryListApiResource;
use App\Models\Category;
use App\Services\ApiResponse\Facades\ApiResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return ApiResponse::withStatus(200)->withAppends(['result' => CategoryListApiResource::collection($categories)])->send();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $clientData = $request->validated();

        $category = Category::create($clientData);

        return ApiResponse::withStatus(200)->withAppends(['result' => new CategoryListApiResource($category)])->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return ApiResponse::withStatus(200)->withAppends(['result' => new CategoryListApiResource($category)])->send();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $clientData = $request->validated();

        $updateResult = $category->update($clientData);

        return ApiResponse::withStatus(200)->withAppends(['result' => $updateResult])->send();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $deleteResult = $category->delete();

        return ApiResponse::withStatus(200)->withAppends(['result' => $deleteResult])->send();
    }
}
