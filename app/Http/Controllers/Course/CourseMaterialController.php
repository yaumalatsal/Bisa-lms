<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;

class CourseMaterialController extends Controller
{
    
    public function index(Course $course)
    {
        $materials = $course->courseMaterials();
        return view('mentor.course_materials.index', compact('course', 'materials'));
    }

    public function create(Course $course)
    {
        return view('mentor.course_materials.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Save the material
        $material = $course->courseMaterials()->create($request->only('title', 'content', 'status'));
    
        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store the image in the 'material_images' directory in 'public' disk
                $path = $image->store('material_images', 'public');
                // Save the image path in the database
                $material->materialImages()->create(['image_path' => $path]);
            }
        }
    
        return redirect()->route('courses.show', $course->id)
            ->with('success', 'Material added successfully.');
    }
    

    public function edit(Course $course, CourseMaterial $material)
    {
        return view('mentor.course_materials.edit', compact('course', 'material'));
    }

    public function update(Request $request, Course $course, CourseMaterial $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|integer',
        ]);

        $material->update($request->all());

        return redirect()->route('courses.show', $course->id)
            ->with('success', 'Material updated successfully.');
    }

    public function destroy(Course $course, CourseMaterial $material)
    {
        $material->delete();

        return redirect()->route('courses.show', $course->id)
            ->with('success', 'Material deleted successfully.');
    }
}
