<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\LecturesCategory;
use App\Models\LecturesGroup;
use App\Models\Question;
use App\Models\User;
use App\Models\UsersAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    private $model;
    private $module;
    private $parent_module;
    private $grandparent_module;
    public function __construct() {
        $this->model = new Question();
        $this->module = 'questions';
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

    public function list($id, Request $request) {
        $lecture = Lecture::query()->find($id);
        $items = $this->model::query();

        if ($request['question'])
            $items->where('question', 'like', '%' . $request['question'] . '%');

        $items->where('lecture_id', $id)->orderBy('order')->select('*');

        return Datatables::of($items)
            ->addColumn('actions', function ($item) use ($id, $lecture) {
                $edit = '<a href="javascript:;" class="dropdown-item" onclick="showModal(\''.route($this->grandparent_module.'.'.$this->parent_module.'.'.$this->module.'.show_form', ['course_id' => $lecture->course_id, 'lecture_id' => $id, 'id' => $item->id]).'\')">
                            <i class="flaticon-edit" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.update').'</span>
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
            ->addColumn('enabled', function ($item) {
                $is_enabled = '';
                $is_enabled.='<div class="col-12">';
                $is_enabled.='<span class="switch">';
                $is_enabled.='<label style="margin: 5px 0 0">';
                $is_enabled.='<label style="margin: 0">';
                if($item->enabled) {
                    $is_enabled.='<input onclick="change_status(' . $item->id . ',\''.route($this->grandparent_module.'.'.$this->parent_module.'.'.$this->module.'.status').'\')" type="checkbox" checked="checked" name="">';
                } else {
                    $is_enabled.='<input onclick="change_status(' . $item->id . ',\''.route($this->grandparent_module.'.'.$this->parent_module.'.'.$this->module.'.status').'\')" type="checkbox" name="">';
                }
                $is_enabled .= '<span></span>';
                $is_enabled .= '</label>';
                $is_enabled .= '</div>';
                $is_enabled .= '</div>';
                return $is_enabled;
            })
            ->addColumn('check', function ($item) {
                return '<label class="checkbox" style="padding: 0">
                            <input type="checkbox" name="select[]" class="select" value="' . $item->id . '" style="display: none"/>
                            <span style="position: relative"></span>
                        </label>';
            })
            ->addColumn('question', function ($item) {
                return cleanText($item->question);
            })
            ->rawColumns(['actions', 'check', 'enabled'])
            ->make(true);
    }

    public function delete(Request $request) {
        $this->model::query()->whereIn('id', $request['ids'])->delete();
        return response()->json([
            'success'=> TRUE,
            'message'=> __('constants.success_delete')
        ]);
    }

    public function status(Request $request) {
        $id = $request->get('id');
        $item = $this->model::query()->find($id);

        if($item->enabled) {
            $item->enabled = 0;
            $item->save();
        } else {
            $item->enabled = 1;
            $item->save();
        }

        return response()->json([
            'success' => TRUE,
            'message' => __('constants.success_status')
        ]);
    }

    public function show_form($course_id, $lecture_id, $id = null) {
        $data['module'] = $this->module;
        $data['record'] = null;
        $data['course_id'] = $course_id;
        $data['lecture_id'] = $lecture_id;
        if ($id) {
            $data['record'] = $this->model::query()->findOrFail($id);
        }
        return response()->json([
            'success' => TRUE,
            'page' => view('CP.'.$this->module.'.form', $data)->render()
        ]);
    }

    public function add_edit(Request $request) {
        $id = isset($request['id']) ? $request['id'] : null;
        $data = $request->toArray();
        unset($data['_token']);

        if ($request->hasFile('image')) $data['image'] = upload_file($request->file('image'), $this->module);

        $this->model::query()->updateOrCreate(['id' => $id], $data);

        return response()->json([
            'success' => TRUE,
            'message' => $id ? __('constants.success_update') : __('constants.success_add'),
        ]);
    }

    public function reorder(Request $request) {
        foreach($request->input('rows', []) as $row)
        {
            $this->model::query()->find($row['id'])->update([
                'order' => $row['order']
            ]);
        }

        return response()->noContent();
    }

}
