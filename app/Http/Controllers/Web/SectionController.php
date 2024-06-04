<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the section.
     */
    public function index()
    {
        $sections = Section::all();
        return response()->json($sections, 200);
    }

    /**
     * Store a newly created section in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required']);
        $section = Section::create($data);
        return response()->json($section, 201);
    }

    /**
     * Display the specified section.
     */
    public function show(string $id)
    {
        $section = Section::findOrFail($id);
        return response()->json($section, 200);
    }

    /**
     * Update the specified section in storage.
     */
    public function update(Request $request, string $id)
    {
        $section = Section::findOrFail($id);
        $data = $request->validate(['name' => ['required', 'unique:sections,name,' . $section->id . ',id']]);
        $section->update($data);
        return response()->json($section, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        //
    }
}
