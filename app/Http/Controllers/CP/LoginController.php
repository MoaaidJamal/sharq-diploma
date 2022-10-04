<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {
        if (auth()->check() && in_array(auth()->user()->type, [1, 5])) {
            if (auth()->user()->type == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user_grades');
            }
        }

        return view('CP.Login');
    }

    public function login(Request $request) {
        if (auth()->attempt(['email' => $request['email'], 'password' => $request['password'], 'enabled' => 1], isset($request->remember))) {
            return redirect()->route('admin.dashboard');
        } else {
            return back()->with('validationErr', __('constants.loginErr'));
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('ws.login');
    }

    public function dashboard() {
        $users = User::query()->WithMainPhase()->where('type', 2)->get();
        $courses = Course::query()->WithMainPhase()->get();
        $data['users'] = $users->count();
        $data['courses'] = $courses->count();
        $data['lectures'] = Lecture::query()->WithMainPhase()->count();
        $data['users_per_gender'] = [
            'male' => User::query()->WithMainPhase()->where('gender', 1)->count(),
            'female' => User::query()->WithMainPhase()->where('gender', 2)->count(),
        ];
        foreach ($courses as $course) {
            $course->users_count = User::query()->whereHas('lectures', function ($q) use ($course){
                $q->where('course_id', $course->getKey())->WithMainPhase();
            })->count();
        }
        $data['users_per_courses'] = $courses;
        return view('CP.home', $data);
    }
}
