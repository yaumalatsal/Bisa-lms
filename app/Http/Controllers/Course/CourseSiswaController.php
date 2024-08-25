<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseAnswer;
use App\Models\CourseCompletion;
use App\Models\CourseMaterial;
use App\Models\CourseMaterialStudent;
use App\Models\CourseQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CourseSiswaController extends Controller
{
    public function index()
    {
        $siswa_id = Session::get('id_siswa');
        $courses = Course::with(['courseCompletions' => function ($query) use ($siswa_id) {
            $query->where('siswa_id', $siswa_id);
        }])->where('status', 1)->get();

        return view('dashboard.courses.index', compact('courses'));
    }

    public function show($courseId)
    {
        $siswa_id = Session::get('id_siswa');

        $course = Course::with(['courseMaterials.materialStudents' => function ($query) use ($siswa_id) {
            $query->where('siswa_id', $siswa_id);
        }])->findOrFail($courseId);

        $courseMaterials = $course->courseMaterials->map(function ($material) {
            $material->is_read = optional($material->materialStudents->first())->is_read;
            $material->read_at = optional($material->materialStudents->first())->created_at;
            return $material;
        });
        
        // Filter the materials where is_read = 1
        $filteredMaterials = $courseMaterials->filter(function ($material) {
            return $material->status == 1;
        });
        
        // Check if all the filtered materials have been read
        $allMaterialsRead = $filteredMaterials->every(function ($material) {
            return $material->is_read;
        });
        
        $materials = $filteredMaterials;

        $questions = $allMaterialsRead ? CourseQuestion::where('course_id', $courseId)->get() : [];

        // Fetch the student's answers
        // $answers = DB::table('course_answers')
        //     ->where('siswa_id', $siswa_id)
        //     ->whereIn('question_id', $questions->pluck('id'))
        //     ->get()
        //     ->keyBy('question_id');
        $answers = CourseAnswer::with(['courseQuestion', 'siswa'])->where('siswa_id', $siswa_id)
            ->whereHas('courseQuestion', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->get();

        return view('dashboard.courses.show', compact('course', 'materials', 'allMaterialsRead', 'questions', 'answers'));
    }


    public function showMaterial($materialId)
    {
        $siswa_id = Session::get('id_siswa');

        // Fetch the current material and course
        $material = CourseMaterial::with('course')->findOrFail($materialId);

        // Get all materials for the course
        $course = Course::with(['courseMaterials.materialStudents' => function ($query) use ($siswa_id) {
            $query->where('siswa_id', $siswa_id);
        }])->findOrFail($material->course_id);

        // Determine current material position
        $materials = $course->courseMaterials->sortBy('id')->values();
        $currentIndex = $materials->search(function ($item) use ($materialId) {
            return $item->id == $materialId;
        });

        $courseMaterials = $course->courseMaterials->map(function ($material) {
            $material->is_read = optional($material->materialStudents->first())->is_read;
            $material->read_at = optional($material->materialStudents->first())->created_at;
            return $material;
        });

        $allMaterialsRead = $courseMaterials->every(function ($material) {
            return $material->is_read;
        });


        // Determine next and previous materials
        $previousMaterial = $currentIndex > 0 ? $materials[$currentIndex - 1] : null;
        $nextMaterial = $currentIndex < $materials->count() - 1 ? $materials[$currentIndex + 1] : null;

        // Mark the material as read
        DB::table('course_material_students')->updateOrInsert(
            ['course_material_id' => $materialId, 'siswa_id' => $siswa_id],
            ['is_read' => true, 'created_at' => now()]
        );

        $completion = CourseCompletion::where('siswa_id', $siswa_id)->where('course_id',$material->course_id)->first();

        // dd($completion);

        return view('dashboard.courses.show-materi', compact('course', 'materials', 'material', 'previousMaterial', 'nextMaterial', 'allMaterialsRead', 'completion'));
    }


    public function markMaterialAsRead($materialId)
    {
        $siswa_id = Session::get('id_siswa');

        DB::table('course_material_students')->updateOrInsert(
            [
                'course_material_id' => $materialId,
                'siswa_id' => $siswa_id
            ],
            ['is_read' => true],
            ['created_at' => now()]
        );

        return redirect()->back()->with('success', 'Material marked as read.');
    }

    public function submitAnswers(Request $request, $courseId)
    {
        $siswa_id = Session::get('id_siswa');
        $answers = $request->input('answers');

        foreach ($answers as $questionId => $answerText) {
            DB::table('course_answers')->updateOrInsert(
                [
                    'question_id' => $questionId,
                    'siswa_id' => $siswa_id
                ],
                [
                    'answer_text' => $answerText,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        CourseCompletion::updateOrCreate(
            [
                'course_id' => $courseId,
                'siswa_id' => $siswa_id
            ],
            [
                'score' => 10,
                'completed' => 1,
            ]
        );
        // DB::table('course_completions')->updateOrInsert(
        //     [
        //         'course_id' => $courseId,
        //         'siswa_id' => $siswa_id
        //     ],
        //     [
        //         'score' => 10,
        //         'completed'=> 1,
        //     ]
        // );

        return redirect()->route('siswa.courses.show', $courseId)->with('success', 'Your answers have been submitted successfully!');
    }
}
