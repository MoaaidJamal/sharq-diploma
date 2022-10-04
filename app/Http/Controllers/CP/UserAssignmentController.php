<?php

namespace App\Http\Controllers\CP;

use App\Exports\AssignmentsExport;
use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\User;
use App\Models\UsersAssignment;
use App\Models\UsersGrades;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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
        $data['lectures'] = Lecture::query()->where('category_id', Lecture::CATEGORY_ASSIGNMENT)->when(auth()->user()->type == User::TYPE_LECTURER, function ($q) {
            $q->whereHas('course', function ($q) {
                $q->where('user_id', auth()->id());
            });
        })->get();
        $data['users'] = User::query()->get();
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list(Request $request) {
        $items = $this->model::query()->WithMainPhase();

        if ($request['user_id'])
            $items->where('user_id', $request['user_id']);

        if ($request['lecture_id'])
            $items->where('lecture_id', $request['lecture_id']);

        $items->orderBy('created_at', 'DESC')->select('*');

        return Datatables::of($items)
            ->addColumn('file', function ($item) {
                return '<a href="'.$item->file.'" target="_blank" class="btn btn-primary">'.__($this->module.'.preview').'</a>';
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
            ->addColumn('actions', function ($item) {
                $edit = '<a href="javascript:;" class="dropdown-item" onclick="showModal(\''.route($this->module.'.show_form', ['id' => $item->id]).'\')">
                            <i class="flaticon-edit" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.update').'</span>
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
            ->rawColumns(['actions', 'file'])
            ->make(true);
    }

    public function download(Request $request)
    {
        $items = $this->model::query()->orderBy('created_at', 'DESC');

        if ($request['user_id'])
            $items = $items->where('user_id', $request['user_id']);

        if ($request['lecture_id'])
            $items = $items->where('lecture_id', $request['lecture_id']);

        return Excel::download(new AssignmentsExport($items->get()), 'assignments.xlsx');
    }

    public function show_form($id = null) {
        $data['module'] = $this->module;
        $data['record'] = null;
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

        $assignment = tap($this->model::query()->find($id))->update($data);

        return response()->json([
            'success' => TRUE,
            'message' => $id ? __('constants.success_update') : __('constants.success_add'),
        ]);
    }

}
