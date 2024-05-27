<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
        return response()->json($news, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string  $id)
    {
        $news = News::findOrfail($id);
        return response()->json($news, 200);
    }

}
