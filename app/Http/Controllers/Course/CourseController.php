<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CourseController extends Controller
{
    public function index()
    {
        $id_mentor = Session::get('id_mentor');
        $courses = Course::where('mentor_id', $id_mentor)->get();
        return view('mentor.courses.index', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::with('courseMaterials')->findOrFail($id);
        return view('mentor.courses.show', compact('course'));
    }

    public function create()
    {
        return view('mentor.courses.create');
    }

    public function store(Request $request)
    {
        $id_mentor = Session::get('id_mentor');
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('course_images', 'public');

        Course::create([
            'mentor_id' => $id_mentor,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'image' => $imagePath,
        ]);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('mentor.courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $id_mentor = Session::get('id_mentor');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('course_images', 'public');
            $course->update([
                'image' => $imagePath,
            ]);
        }

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
