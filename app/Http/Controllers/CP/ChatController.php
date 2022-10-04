<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\User;
use App\Models\UserAttempt;
use App\Models\UsersCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ChatController extends Controller
{
    private $model;
    private $module;
    public function __construct() {
        $this->model = new Chat();
        $this->module = 'chats';
    }

    public function index() {
        $data['module'] = $this->module;
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list(Request $request) {
        $items = $this->model::query()->orderBy('created_at', 'DESC')->select('*');

        return Datatables::of($items)
            ->addColumn('actions', function ($item) {
                $delete = '<a href="javascript:;" class="dropdown-item" onclick="delete_items('.$item->id.', \''.route($this->module.'.delete').'\')">
                            <i class="flaticon-delete" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.delete').'</span>
                        </a>';
                $clear_messages = '<a href="javascript:;" class="dropdown-item" onclick="clear_messages(\''.route($this->module.'.clear_messages', ['id' => $item->id]).'\')">
                            <i class="flaticon-delete" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__($this->module.'.clear_messages').'</span>
                        </a>';
                return '<div class="dropdown dropdown-inline">
                        <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="true">
                            <i class="la la-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            '.$clear_messages.'
                            '.$delete.'
                        </div>
                    </div>';
            })
            ->addColumn('singular', function ($item) {
                return optional($item->phase)->title ?: $item->users()->pluck('name')->implode(', ');
            })
            ->addColumn('check', function ($item) {
                return '<label class="checkbox" style="padding: 0">
                            <input type="checkbox" name="select[]" class="select" value="' . $item->id . '" style="display: none"/>
                            <span style="position: relative"></span>
                        </label>';
            })
            ->addColumn('messages_count', function ($item) {
                return $item->messages()->count();
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

    public function clear_messages($id) {
        $this->model::query()->find($id)->messages()->delete();
        return response()->json([
            'success'=> TRUE,
            'message'=> __('constants.success_delete')
        ]);
    }
}
