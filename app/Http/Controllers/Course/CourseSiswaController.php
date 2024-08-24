<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseAnswer;
use App\Models\CourseQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CourseSiswaController extends Controller
{
    public function index()
    {
        $courses = Course::all(); // Adjust this if you need to filter courses
        return view('dashboard.courses.index', compact('courses'));
    }

    public function show($courseId)
    {
        $course = Course::with('courseMaterials')->findOrFail($courseId);
        $siswa_id = Session::get('id_siswa');
        // $siswa_id = auth()->user()->id;

        $courseMaterials = $course->courseMaterials->map(function ($material) use ($siswa_id) {
            $material->is_read = DB::table('course_material_student')
                ->where('course_material_id', $material->id)
                ->where('student_id', $siswa_id)
                ->value('is_read');
            return $material;
        });

        $allMaterialsRead = $courseMaterials->every(function ($material) {
            return $material->is_read;
        });

        $materials = $courseMaterials;

        $questions = $allMaterialsRead ? CourseQuestion::where('course_id', $courseId)->get() : [];

        return view('dashboard.courses.show', compact('course', 'materials', 'allMaterialsRead', 'questions'));
    }

    public function markMaterialAsRead($materialId)
    {
        $siswa_id = Session::get('id_siswa');

        DB::table('course_material_student')->updateOrInsert(
            ['course_material_id' => $materialId, 'student_id' => $siswa_id],
            ['is_read' => true]
        );

        return redirect()->back()->with('success', 'Material marked as read.');
    }

    public function submitAnswers(Request $request, $courseId)
    {
        $siswa_id = Session::get('id_siswa');

        foreach ($request->answers as $questionId => $answerText) {
            CourseAnswer::updateOrCreate(
                ['question_id' => $questionId, 'siswa_id' => $siswa_id],
                ['answer_text' => $answerText]
            );
        }

        return redirect()->route('siswa.courses.index')->with('success', 'Answers submitted successfully.');
    }
}
