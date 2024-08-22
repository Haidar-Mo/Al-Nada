<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\SuccessStoryRequest;
use App\Models\SuccessStory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuccessStoryController extends Controller
{
    /**
     * Display a listing of the Success Stories
     * @param Request $request  
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = SuccessStory::query();
        $stories  = $this->applyFilters($request, $query);
        return response()->json($stories, 200);
    }

    /**
     * Display the specified story
     * @param string $id The ID of the story
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $story = SuccessStory::findOrFail($id);
        return response()->json($story, 200);
    }

    /**
     * Store a newly created strory in storage
     * @param
     * @return JsonResponse
     */
    public function store(SuccessStoryRequest $request)
    {
        DB::beginTransaction();
        $path = '';
        try {
            $image = $request->file('image');
            $path = $image->store('Story', 'public');
            $story = SuccessStory::create([
                'type' => $request->type,
                'name' => $request->name,
                'description' => $request->description,
                'image' => $path,
            ]);
            DB::commit();
            return response()->json($story, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            if (Storage::exists("public/" . $path))
                Storage::delete("public/" . $path);
            return response()->json($e->getMessage(), 400);
        }
    }

    /**
     * Update the specified story in storage.
     */
    public function update(SuccessStoryRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $story = SuccessStory::findOrFail($id);
            $story->update([
                'type' => $request->type,
                'name' => $request->name,
                'description' => $request->description,
            ]);
            if ($request->file('image')) {
                if (Storage::exists("public/" . $story->image))
                    Storage::delete("public/" . $story->image);

                $image = $request->file('image');
                $path = $image->store('Story', 'public');
                $story->update(['image' => $path]);
            }
            DB::commit();
            return response()->json($story, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $story = SuccessStory::findOrFail($id);
            if (Storage::exists("public/" . $story->image))
                Storage::delete("public/" . $story->image);
            $story->delete();
            $story->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }
}
