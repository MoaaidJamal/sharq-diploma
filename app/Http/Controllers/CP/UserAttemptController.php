<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\LecturesCategory;
use App\Models\LecturesGroup;
use App\Models\Question;
use App\Models\User;
use App\Models\UserAttempt;
use App\Models\UsersAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserAttemptController extends Controller
{
    private $model;
    private $module;
    private $parent_module;
    private $grandparent_module;
    public function __construct() {
        $this->model = new UserAttempt();
        $this->module = 'users_attempts';
        $this->parent_module = 'lectures';
        $this->grandparent_module = 'courses';
    }

    public function index($id) {
        $data['module'] = $this->module;
        $data['parent_module'] = $this->parent_module;
        $data['grandparent_module'] = $this->grandparent_module;
        $data['parent'] = Lecture::query()->findOrFail($id);
        $data['course_id'] = $data['parent']->course_id;
        $data['lecture_id'] = $id;
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list($id) {
        $lecture = Lecture::query()->find($id);
        $items = $this->model::query()->where('lecture_id', $id)->select('*');

        return Datatables::of($items)
            ->addColumn('actions', function ($item) use ($id, $lecture) {
                $edit = '<a href="javascript:;" class="dropdown-item" onclick="showModal(\''.route($this->grandparent_module.'.'.$this->parent_module.'.'.$this->module.'.show_form', ['course_id' => $lecture->course_id, 'lecture_id' => $id, 'id' => $item->id]).'\')">
                            <i class="flaticon-layers" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">Attempt Detials</span>
                        </a>';
                $delete = '<a href="javascript:;" class="dropdown-item" onclick="delete_items('.$item->id.', \''.route($this->grandparent_module.'.'.$this->parent_module.'.'.$this->module.'.delete').'\')">
                            <i class="flaticon-delete" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.delete').'</span>
                        </a>';
                return '<div class="dropdown dropdown-inline">
                        <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="true">
                            <i class="la la-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            '.$edit.'
                            '.$delete.'
                        </div>
                    </div>';
            })
            ->addColumn('check', function ($item) {
                return '<label class="checkbox" style="padding: 0">
                            <input type="checkbox" name="select[]" class="select" value="' . $item->id . '" style="display: none"/>
                            <span style="position: relative"></span>
                        </label>';
            })
            ->addColumn('user_id', function ($item) {
                return optional($item->user)->name;
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

    public function delete(Request $request) {
        $this->model::query()->whereIn('id', $request['ids'])->delete();
        return response()->json([
            'success'=> TRUE,
            'message'=> __('constants.success_delete')
        ]);
    }

    public function show_form($course_id, $lecture_id, $id) {
        $data['record'] = $this->model::query()->findOrFail($id);
        return response()->json([
            'success' => TRUE,
            'page' => view('CP.'.$this->module.'.form', $data)->render()
        ]);
    }
}
