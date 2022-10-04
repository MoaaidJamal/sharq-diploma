<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\User;
use App\Models\UserAttempt;
use App\Models\UsersCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserCourseController extends Controller
{
    private $model;
    private $module;
    public function __construct() {
        $this->model = new UsersCourse();
        $this->module = 'users_courses';
    }

    public function index() {
        $data['module'] = $this->module;
        $data['courses'] = Course::query()->get();
        $data['users'] = User::query()->get();
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list(Request $request) {
        $items = $this->model::query()->whereHas('user')->whereHas('course');

        if ($request['user_id'])
            $items->where('user_id', $request['user_id']);

        if ($request['course_id'])
            $items->where('course_id', $request['course_id']);

        $items->orderBy('created_at', 'DESC')->select('*');

        return Datatables::of($items)
            ->addColumn('name', function ($item) {
                return $item->user->name;
            })
            ->addColumn('email', function ($item) {
                return $item->user->email;
            })
            ->addColumn('course_id', function ($item) {
                return $item->course->title;
            })
            ->addColumn('percentage', function ($item) {
                return $item->course->getUserScore($item->user_id) . '%';
            })
            ->make(true);
    }
}
