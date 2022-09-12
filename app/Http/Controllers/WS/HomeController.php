<?php

namespace App\Http\Controllers\WS;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Interest;
use App\Models\Lecture;
use App\Models\Partner;
use App\Models\Slider;
use App\Models\User;

class HomeController extends Controller
{
    public function index() {
        $data['sliders'] = Slider::query()->where('enabled', 1)->get();
        $data['partners'] = Partner::query()->where('enabled', 1)->get();
        $data['courses'] = Course::query()->where('enabled', 1)->get();
        $data['gallery'] = settings_row()->files->take(6);
        $data['mates'] = User::query()->whereKeyNot(auth()->id())->limit(8)->where('type', 2)->where('enabled', 1)->where('verified', 1)->get();
        $data['mentors'] = User::query()->limit(8)->where('type', 3)->where('enabled', 1)->get();
        $data['team'] = User::query()->where('type', 4)->where('enabled', 1)->get();
        return view('WS.home', $data);
    }

    public function gallery() {
        $data['images'] = settings_row()->files;
        return view('WS.gallery', $data);
    }

    public function teammates($interest_id = null) {
        $data['mates'] = User::query()->when($interest_id, function ($q) use ($interest_id) {
            $q->whereHas('user_interests', function ($q) use ($interest_id) {
                $q->where('interest_id', $interest_id);
            });
        })->whereKeyNot(auth()->id())->where('type', 2)->where('enabled', 1)->where('verified', 1)->paginate(12);
        $data['interests'] = Interest::query()->where('enabled', 1)->get();
        $data['interest_id'] = $interest_id;
        return view('WS.teammates', $data);
    }

    public function mentors() {
        $data['mentors'] = User::query()->whereKeyNot(auth()->id())->where('type', 3)->where('enabled', 1)->paginate(12);
        return view('WS.mentors', $data);
    }

    public function schedule() {
        $all_modules = Course::query()
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('start_date', '>=', now()->startOfDay())
            ->where('enabled', 1)
            ->get();
        $courses = [];
        foreach ($all_modules as $course) {
            $course_score = $course->getUserScore();
            if ($course_score == 100) continue;
            $previous_course = $course->previous();
            $previous_course_score = $previous_course ? $previous_course->getUserScore() : 0;
            if ($previous_course && $previous_course_score != 100) continue;
            if (!$previous_course || $previous_course_score == 100) $courses[] = $course;
        }
        $data['courses'] = $courses;
        return view('WS.schedule', $data);
    }

    public function modules() {
        $data['courses'] = Course::query()->where('enabled', 1)->get();
        return view('WS.courses.index', $data);
    }
}
