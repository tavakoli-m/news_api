<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\StoreBannerRequest;
use App\Http\Requests\Banner\UpdateBannerRequest;
use App\Http\Resources\Banner\BannerListApiResource;
use App\Models\Banner;
use App\Services\ApiResponse\Facades\ApiResponse;
use App\Services\Image\ImageService;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();

        return ApiResponse::withStatus(200)->withAppends(['result' => BannerListApiResource::collection($banners)])->send();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request, ImageService $imageService)
    {
        $clientData = $request->validated();

        $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'banners');
        $result = $imageService->createIndexAndSave($request->file('image'));
        if ($result === false) {
            return ApiResponse::withStatus(500)->withData(['result' => false])->withMessage('An error occurred while uploading the image.')->send();
        }
        $clientData['image'] = $result;

        $banner = Banner::create($clientData);

        return ApiResponse::withStatus(200)->withAppends(['result' => new BannerListApiResource($banner)])->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return ApiResponse::withStatus(200)->withAppends(['result' => new BannerListApiResource($banner)])->send();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner, ImageService $imageService)
    {
        $clientData = $request->validated();

        if ($request->hasFile('image')) {
            if (!empty($banner->image)) {
                $imageService->deleteDirectoryAndFiles($banner->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'banners');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return ApiResponse::withStatus(500)->withData(['result' => false])->withMessage('An error occurred while uploading the image.')->send();
            }
            $clientData['image'] = $result;
        }

        $updateResult = $banner->update($clientData);

        return ApiResponse::withStatus(status: 200)->withData(['result' => $updateResult])->send();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner, ImageService $imageService)
    {
        if (!empty($banner->image)) {
            $imageService->deleteDirectoryAndFiles($banner->image['directory']);
        }

        $deleteResult = $banner->delete();

        return ApiResponse::withStatus(status: 200)->withData(['result' => $deleteResult])->send();
    }
}
