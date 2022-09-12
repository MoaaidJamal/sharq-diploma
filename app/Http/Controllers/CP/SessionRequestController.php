<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsersMentorsRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SessionRequestController extends Controller
{
    private $model;
    private $module;
    private $parent_module;
    public function __construct() {
        $this->model = new UsersMentorsRequest();
        $this->module = 'sessions_requests';
        $this->parent_module = 'users';
    }

    public function index($id) {
        $data['module'] = $this->module;
        $data['parent_module'] = $this->parent_module;
        $data['parent'] = User::query()->where('type', 3)->findOrFail($id);
        $data['users'] = User::query()->where('type', 2)->get();
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list($id, Request $request) {
        $items = $this->model::query();

        if ($request['user_id'])
            $items->where('user_id', $request['user_id']);

        if($request['date']) {
            $date_from = Carbon::parse(explode(' - ', $request['date'])[0])->toDateTimeString();
            $date_to = Carbon::parse(explode(' - ', $request['date'])[1])->toDateTimeString();
            $items->whereBetween('date_from',[$date_from, $date_to]);
        }

        $items->where('mentor_id', $id)->select('*');

        return Datatables::of($items)
            ->addColumn('actions', function ($item) use ($id) {
                $delete = '<a href="javascript:;" class="dropdown-item" onclick="delete_items('.$item->id.', \''.route($this->parent_module.'.'.$this->module.'.delete').'\')">
                            <i class="flaticon-delete" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.delete').'</span>
                        </a>';
                if ($delete) {
                    return '<div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="true">
                                <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                '.$delete.'
                            </div>
                        </div>';
                } else {
                    return '';
                }
            })
            ->addColumn('check', function ($item) {
                return '<label class="checkbox" style="padding: 0">
                            <input type="checkbox" name="select[]" class="select" value="' . $item->id . '" style="display: none"/>
                            <span style="position: relative"></span>
                        </label>';
            })
            ->addColumn('user_id', function ($item) {
                return optional($item->user)->name ?: optional($item->user)->email;
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

}
