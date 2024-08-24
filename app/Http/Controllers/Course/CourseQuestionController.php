<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseQuestion;
use Illuminate\Http\Request;

class CourseQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        $course = Course::findOrFail($course_id);
        $questions = CourseQuestion::where('course_id', $course_id)->get();

        return view('mentor.course_questions.index', compact('course', 'questions'));
    }

    // public function create($course_id)
    // {
    //     $course = Course::findOrFail($course_id);
    //     return view('mentor.course_questions.create', compact('course'));
    // }

    public function store(Request $request, $course_id)
    {
        $request->validate([
            'question_text' => 'required|string',
        ]);

        CourseQuestion::create([
            'course_id' => $course_id,
            'question_text' => $request->question_text,
        ]);

        return redirect()->route('course.questions.index', $course_id)
            ->with('success', 'Question added successfully.');
    }

    // public function edit($course_id, $id)
    // {
    //     $course = Course::findOrFail($course_id);
    //     $question = CourseQuestion::findOrFail($id);

    //     return view('mentor.course_questions.edit', compact('course', 'question'));
    // }

    public function update(Request $request, $course_id, $id)
    {
        $request->validate([
            'question_text' => 'required|string',
        ]);

        $question = CourseQuestion::findOrFail($id);
        $question->update([
            'question_text' => $request->question_text,
        ]);

        return redirect()->route('course.questions.index', $course_id)
            ->with('success', 'Question updated successfully.');
    }

    public function destroy($course_id, $id)
    {
        $question = CourseQuestion::findOrFail($id);
        $question->delete();

        return redirect()->route('course.questions.index', $course_id)
            ->with('success', 'Question deleted successfully.');
    }
}
