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

class AssignmentController extends Controller
{
    private $model;
    private $module;
    private $parent_module;
    private $grandparent_module;
    public function __construct() {
        $this->model = new UsersAssignment();
        $this->module = 'assignments';
        $this->parent_module = 'lectures';
        $this->grandparent_module = 'courses';
    }

    public function index($id) {
        $data['module'] = $this->module;
        $data['parent_module'] = $this->parent_module;
        $data['grandparent_module'] = $this->grandparent_module;
        $data['parent'] = Lecture::query()->findOrFail($id);
        $data['users'] = User::query()->whereHas('users_assignments', function ($q) use ($id) {
            $q->where('lecture_id', $id);
        })->get();
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list($id, Request $request) {
        $items = $this->model::query();

        if ($request['user_id'])
            $items->where('user_id', $request['user_id']);

        $items->where('lecture_id', $id)->orderBy('created_at', 'DESC')->select('*');

        return Datatables::of($items)
            ->addColumn('actions', function ($item) use ($id) {
                $delete = '<a href="javascript:;" class="dropdown-item" onclick="delete_items('.$item->id.', \''.route($this->grandparent_module.'.'.$this->parent_module.'.'.$this->module.'.delete').'\')">
                            <i class="flaticon-delete" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.delete').'</span>
                        </a>';
                return '<div class="dropdown dropdown-inline">
                        <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="true">
                            <i class="la la-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            '.$delete.'
                        </div>
                    </div>';
            })
            ->addColumn('file', function ($item) {
                return '<a href="'.$item->file.'" target="_blank">'.$item->file.'</a>';
            })
            ->addColumn('user_id', function ($item) {
                return optional($item->user)->name ?: optional($item->user)->email;
            })
            ->addColumn('created_at', function ($item) {
                return Carbon::parse($item->created_at)->toDateTimeString();
            })
            ->addColumn('check', function ($item) {
                return '<label class="checkbox" style="padding: 0">
                            <input type="checkbox" name="select[]" class="select" value="' . $item->id . '" style="display: none"/>
                            <span style="position: relative"></span>
                        </label>';
            })
            ->rawColumns(['actions', 'check', 'file'])
            ->make(true);
    }

    public function delete(Request $request) {
        $this->model::query()->whereIn('id', $request['ids'])->delete();
        return response()->json([
            'success'=> TRUE,
            'message'=> __('constants.success_delete')
        ]);
    }

}
