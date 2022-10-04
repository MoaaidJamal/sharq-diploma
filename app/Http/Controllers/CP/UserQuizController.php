<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\User;
use App\Models\UserAttempt;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserQuizController extends Controller
{
    private $model;
    private $module;
    public function __construct() {
        $this->model = new UserAttempt();
        $this->module = 'users_quizzes';
    }

    public function index() {
        $data['module'] = $this->module;
        $data['lectures'] = Lecture::query()->where('category_id', Lecture::CATEGORY_ASSIGNMENT)->when(auth()->user()->type == User::TYPE_LECTURER, function ($q) {
            $q->whereHas('course', function ($q) {
                $q->where('user_id', auth()->id());
            });
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
            ->addColumn('actions', function ($item) {
                $edit = '<a href="javascript:;" class="dropdown-item" onclick="showModal(\''.route($this->module.'.show_form', ['id' => $item->id]).'\')">
                            <i class="flaticon-layers" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">Attempt Detials</span>
                        </a>';
                return '<div class="dropdown dropdown-inline">
                        <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="true">
                            <i class="la la-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            '.$edit.'
                        </div>
                    </div>';
            })
            ->addColumn('user_id', function ($item) {
                return optional($item->user)->name;
            })
            ->addColumn('lecture_id', function ($item) {
                return optional($item->lecture)->title;
            })
            ->addColumn('mark', function ($item) {
                $mark = 0;
                foreach ($item->answers as $answer) {
                    if ($answer->question && $answer->question->correct_answer == $answer->answer) {
                        $mark++;
                    }
                }
                return $mark . '/' . count($item->answers);
            })
            ->rawColumns(['actions', 'check'])
            ->make(true);
    }

    public function show_form($id) {
        $data['record'] = $this->model::query()->findOrFail($id);
        return response()->json([
            'success' => TRUE,
            'page' => view('CP.'.$this->module.'.form', $data)->render()
        ]);
    }
}
