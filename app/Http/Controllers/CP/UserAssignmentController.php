<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\LecturesCategory;
use App\Models\LecturesGroup;
use App\Models\User;
use App\Models\UsersAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserAssignmentController extends Controller
{
    private $model;
    private $module;
    public function __construct() {
        $this->model = new UsersAssignment();
        $this->module = 'user_assignments';
    }

    public function index() {
        $data['module'] = $this->module;
        $data['lectures'] = Lecture::query()->where('category_id', Lecture::CATEGORY_ASSIGNMENT)->whereHas('course', function ($q) {
            $q->where('user_id', auth()->id());
        })->get();
        $data['users'] = User::query()->get();
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list(Request $request) {
        $items = $this->model::query();

        if ($request['user_id'])
            $items->where('user_id', $request['user_id']);

        if ($request['lecture_id'])
            $items->where('lecture_id', $request['lecture_id']);

        $items->orderBy('created_at', 'DESC')->select('*');

        return Datatables::of($items)
            ->addColumn('file', function ($item) {
                return '<a href="'.$item->file.'" target="_blank">'.$item->file.'</a>';
            })
            ->addColumn('user_id', function ($item) {
                return optional($item->user)->name ?: optional($item->user)->email;
            })
            ->addColumn('lecture_id', function ($item) {
                return optional($item->lecture)->title;
            })
            ->addColumn('created_at', function ($item) {
                return Carbon::parse($item->created_at)->toDateTimeString();
            })
            ->rawColumns(['file'])
            ->make(true);
    }

}
