<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\NewsRequest;
use App\Models\News;
use App\Models\NewsImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the News
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $orderBy = $request->input('order_by', 'id');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter', 'id');
        $search  = $request->input('search');

        $news = News::where($filter, 'LIKE', '%' . $search . '%')->orderBy($orderBy, $order)->paginate($perPage);
        return response()->json($news, 200);
    }


    /**
     * Display the specified resource.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $news = News::findOrfail($id);
        return response()->json($news, 200);
    }


    /**
     * Store a newly created News in storage.
     * @param NewsRequest $request
     * @return JsonResponse
     */
    public function store(NewsRequest $request)
    {
        DB::beginTransaction();
        try {
            $news = News::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            // Handle the image files
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $path = $image->store('News', 'public');
                    $news->image()->create([
                        'news_id' => $news->id,
                        'url' => $path,
                    ]);
                }
            }
            DB::commit();
            return response()->json($news, 201);
        } catch (\Exception $e) {
            DB::rollback();

            if (Storage::exists("public/" . $path))
                Storage::delete("public/" . $path);

            return response()->json($e->getMessage(), 500);
        }
    }


    /**
     * Update the specified resource in storage.
     * @param NewsRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(NewsRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $news = News::findOrfail($id);
            $news->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            // Handle the image files
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $path = $image->store('News', 'public');
                    $news->image()->create([
                        'news_id' => $news->id,
                        'url' => $path,
                    ]);
                }
            }
            DB::commit();
            return response()->json($news, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Delete news images (passing array of images)
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    /* public function deleteImages(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $images = $request->images;
            foreach ($images as $image) {
                $image = NewsImage::find($image);
                if ($image) {
                    if (Storage::exists("public/" . $image->url))
                        Storage::delete("public/" . $image->url);
                    $image->delete();
                }
            }
            DB::commit();
            $news = News::findOrFail($id);
            return response()->json($news, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }*/


    /**
     * Delete new image (singel Image)
     * @param string $id
     * @return JsonResponse
     */
    public function deleteImage(string $id)
    {
        DB::beginTransaction();
        try {
            $image = NewsImage::findOrFail($id);
            if (Storage::exists("public/" . $image->url))
                Storage::delete("public/" . $image->url);
            $image->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $news = News::findOrFail($id);
            $images = $news->images;
            foreach ($images as $image) {
                if (Storage::exists("public/" . $image->url))
                    Storage::delete("public/" . $image->url);
            }
            $news->image()->delete();
            $news->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }
}
