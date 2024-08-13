<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\Request;

class SuccessStoryController extends Controller
{
    /**
     * Display a listing of the Success Stories
     * @return JsonResponse
     */
    public function index()
    {
        $stories = SuccessStory::latest()->get();
        return response()->json($stories, 200);
    }

    /**
     * Display a listing of the Success Lady's Stories
     * @return JsonResponse
     */
    public function getLadyStory()
    {
        $stories = SuccessStory::where('type', 1)->latest()->get();
        return response()->json($stories, 200);
    }

    /**
     * Display a listing of the Success Students's Stories
     * @return JsonResponse
     */
    public function getStudentStory()
    {
        $stories = SuccessStory::where('type', 2)->latest()->get();
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
}
