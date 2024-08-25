<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseAnswer;
use App\Models\CourseQuestion;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


    public function showQuestions($courseId)
    {
        $course = Course::with('courseQuestions')->findOrFail($courseId);
        $questions = $course->courseQuestions;

        return view('dashboard.courses.show-questions', compact('course', 'questions'));
    }

    public function showAnswers($courseId)
    {
        $answers = CourseAnswer::with(['courseQuestion', 'siswa'])
            ->whereHas('courseQuestion', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->get();
        return view('mentor.courses.show-answer', compact('answers', "courseId"));
    }

    public function updateScore(Request $request, $courseId, $answerId)
    {
        // Validate the request
        $request->validate([
            'score' => 'required|integer|min:0|max:100', // Adjust min and max as needed
        ]);

        // Find the specific answer by ID
        $answer = CourseAnswer::where('id', $answerId)
            ->whereHas('courseQuestion', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->firstOrFail();

        // Update the score
        $answer->score = $request->input('score');
        $answer->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Score updated successfully!');
    }
}
