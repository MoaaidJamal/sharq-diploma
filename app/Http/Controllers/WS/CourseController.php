<?php

namespace App\Http\Controllers\WS;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Question;
use App\Models\Review;
use App\Models\UserAttempt;
use App\Models\UserAttemptAnswer;
use App\Models\UsersAssignment;
use App\Models\UsersCourse;
use App\Models\UsersLecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{

    public function show($course_id, $lecture_id = null) {
        $data['course'] = Course::query()->whereIn('phase_id', userPhases())->where('enabled', 1)->findOrFail($course_id);
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

    public function more_reviews(Request $request) {
        $data['reviews'] = Review::query()->where('course_id', $request['id'])->paginate(6);
        return response()->json([
            'success' => TRUE,
            'last_page' => !$data['reviews']->hasMorePages(),
            'page' => view('WS.courses.list_reviews', $data)->render()
        ]);
    }

    public function add_review(Request $request)
    {
        $rules = [
            'id' => ['required', Rule::exists('courses', 'id')],
            'rate' => ['required', Rule::in([1,2,3,4,5])],
            'comment' => 'required|string',
        ];
        $validate = Validator::make(request()->all(), $rules);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->errors()->all()
            ]);
        } else {
            $data['reviews'] = [Review::query()->create([
                'course_id' => $request['id'],
                'user_id' => auth()->id(),
                'rate' => $request['rate'],
                'comment' => $request['comment'],
            ])];
            return response()->json([
                'success' => TRUE,
                'message' => __('ws.success_rate'),
                'page' => view('WS.courses.list_reviews', $data)->render(),
                'summery' => view('WS.courses.reviews_summery', ['course' => Course::query()->find($request['id'])])->render(),
            ]);
        }
    }

    public function delete_review(Request $request)
    {
        $review = Review::query()->findOrFail($request['id']);
        $course_id = $review->course_id;
        $review->delete();
        $summery = view('WS.courses.reviews_summery', ['course' => Course::query()->find($course_id)])->render();
        return response()->json([
            'success' => TRUE,
            'summery' => $summery,
            'message' => __('ws.review_deleted'),
        ]);
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
            'file' => $request->file('file')->storeAs('assignments', auth()->user()->name . '_' . now()->toDateTimeString() . '.' . $request->file('file')->getClientOriginalExtension()),
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
        UsersLecture::query()->updateOrCreate([
            'user_id' => auth()->id(),
            'lecture_id' => $request['lecture_id'],
        ]);
        UsersCourse::query()->updateOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $lecture->course_id,
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
