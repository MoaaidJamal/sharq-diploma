<?php

namespace App\Http\Controllers\WS;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Question;
use App\Models\UserAttempt;
use App\Models\UserAttemptAnswer;
use App\Models\UsersAssignment;
use App\Models\UsersLecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{

    public function show($course_id, $lecture_id = null) {
        $data['course'] = Course::query()->where('enabled', 1)->findOrFail($course_id);
        if ($lecture_id) {
            $data['lecture'] = Lecture::query()->where('enabled', 1)->findOrFail($lecture_id);
        } else {
            $data['lecture'] = $data['course']->first_lecture;
        }
        if (!$data['lecture']) {
            abort(404);
        }
        $data['assignment'] = UsersAssignment::query()->where('user_id', auth()->id())->where('lecture_id', $data['lecture']->id)->first();
        $data['user_lecture'] = UsersLecture::query()->where('user_id', auth()->id())->where('lecture_id', $data['lecture']->id)->first();
        if ($data['lecture']->category_id == Lecture::CATEGORY_QUIZ) {
            $data['quiz_attempt'] = auth()->user()->user_attempts()->where('lecture_id', $data['lecture']->id)->first();
            if ($data['quiz_attempt']) {
                $mark = 0;
                foreach ($data['quiz_attempt']->answers as $answer) {
                    if ($answer->question && $answer->question->correct_answer == $answer->answer) {
                        $mark++;
                    }
                }
                $data['mark'] = $mark;
                $data['questions_count'] = count($data['quiz_attempt']->answers);
                $data['mark_text'] = $mark . '/' . count($data['quiz_attempt']->answers);
            }
        }
        return view('WS.courses.show', $data);
    }

    public function assignment(Request $request) {
        $validate = Validator::make($request->all(), [
            'lecture_id' => ['required', 'integer', Rule::exists('lectures', 'id')->where('enabled', 1)],
            'file' => ['required', 'file'],
        ]);
        if ($validate->fails()) {
            return back()->with('errors', $validate->errors()->all())->with('error', 'Please check the data you entered');
        }
        UsersAssignment::query()->where('user_id', auth()->id())->where('lecture_id', $request['lecture_id'])->delete();
        UsersAssignment::query()->create([
            'user_id' => auth()->id(),
            'lecture_id' => $request['lecture_id'],
            'file' => upload_file($request->file('file'), 'lectures'),
            'file_name' => $request->file('file')->getClientOriginalName(),
        ]);
        return back()->with('success', 'Your file has been submitted successfully');
    }

    public function complete_lecture(Request $request) {
        $validate = Validator::make($request->all(), [
            'lecture_id' => ['required', 'integer', Rule::exists('lectures', 'id')->where('enabled', 1)],
        ]);
        if ($validate->fails()) {
            return back()->with('errors', $validate->errors()->all())->with('error', 'Please check the data you entered');
        }
        $lecture = Lecture::query()->find($request['lecture_id']);
        UsersLecture::query()->where('user_id', auth()->id())->where('lecture_id', $request['lecture_id'])->delete();
        UsersLecture::query()->create([
            'user_id' => auth()->id(),
            'lecture_id' => $request['lecture_id'],
        ]);
        if ($lecture->next()) {
            return redirect()->route('ws.course.show', ['course_id' => $lecture->next()->course_id, 'lecture_id' => $lecture->next()->id])->with('success', 'Your completed the lecture successfully');
        }
        return back()->with('success', 'Your completed the lecture successfully');
    }

    public function quiz($id)
    {
        $data['lecture'] = Lecture::query()->where('enabled', 1)->findOrFail($id);
        $data['questions'] = Question::query()->where('lecture_id', $id)->where('enabled', 1)->limit(10)->inRandomOrder()->get();
        return view('WS.courses.quiz', $data);
    }

    public function quiz_attempt(Request $request) {
        $validate = Validator::make($request->all(), [
            'lecture_id' => ['required', 'integer', Rule::exists('lectures', 'id')->where('enabled', 1)->where('category_id', Lecture::CATEGORY_QUIZ)],
            'questions' => ['required', 'array'],
        ]);
        if ($validate->fails()) {
            return back()->with('errors', $validate->errors()->all())->with('error', 'Please check the data you entered');
        }
        $lecture = Lecture::query()->find($request['lecture_id']);
        $user_attempt = UserAttempt::query()->create([
            'user_id' => auth()->id(),
            'lecture_id' => $request['lecture_id'],
        ]);
        foreach ($request['questions'] as $question_id => $answer) {
            UserAttemptAnswer::query()->create([
                'attempt_id' => $user_attempt->getKey(),
                'question_id' => $question_id,
                'answer' => $answer
            ]);
        }
        UsersLecture::query()->where('user_id', auth()->id())->where('lecture_id', $request['lecture_id'])->delete();
        UsersLecture::query()->create([
            'user_id' => auth()->id(),
            'lecture_id' => $request['lecture_id'],
        ]);
        return redirect()->route('ws.course.show', ['course_id' => $lecture->course_id, 'lecture_id' => $lecture->id])->with('success', 'You successfully submitted your quiz attempt');
    }
}
