<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsersDate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserDateController extends Controller
{
    private $model;
    private $module;
    private $parent_module;
    public function __construct() {
        $this->model = new UsersDate();
        $this->module = 'user_dates';
        $this->parent_module = 'users';
    }

    public function index($id) {
        $data['module'] = $this->module;
        $data['parent_module'] = $this->parent_module;
        $data['parent'] = User::query()->where('type', 3)->findOrFail($id);
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list($id, Request $request) {
        $items = $this->model::query();

        if($request['date']) {
            $date_from = Carbon::parse(explode(' - ', $request['date'])[0])->toDateTimeString();
            $date_to = Carbon::parse(explode(' - ', $request['date'])[1])->toDateTimeString();
            $items->whereBetween('date_from',[$date_from, $date_to]);
        }

        $items->where('user_id', $id)->select('*');

        return Datatables::of($items)
            ->addColumn('actions', function ($item) use ($id) {
                $edit = '<a href="javascript:;" class="dropdown-item" onclick="showModal(\''.route($this->parent_module.'.'.$this->module.'.show_form', ['user_id' => $id,'id' => $item->id]).'\')">
                            <i class="flaticon-edit" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.update').'</span>
                        </a>';
                $delete = '<a href="javascript:;" class="dropdown-item" onclick="delete_items('.$item->id.', \''.route($this->parent_module.'.'.$this->module.'.delete').'\')">
                            <i class="flaticon-delete" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.delete').'</span>
                        </a>';
                if ($edit || $delete) {
                    return '<div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="true">
                                <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                '.$edit.'
                                '.$delete.'
                            </div>
                        </div>';
                } else {
                    return '';
                }
            })
            ->addColumn('enabled', function ($item) {
                $is_enabled = '';
                $is_enabled.='<div class="col-12">';
                $is_enabled.='<span class="switch">';
                $is_enabled.='<label style="margin: 5px 0 0">';
                $is_enabled.='<label style="margin: 0">';
                if($item->enabled) {
                    $is_enabled.='<input onclick="change_status(' . $item->id . ',\''.route($this->parent_module.'.'.$this->module.'.status').'\')" type="checkbox" checked="checked" name="">';
                } else {
                    $is_enabled.='<input onclick="change_status(' . $item->id . ',\''.route($this->parent_module.'.'.$this->module.'.status').'\')" type="checkbox" name="">';
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
            ->rawColumns(['actions', 'check', 'enabled', 'image'])
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

    public function show_form($user_id, $id = null) {
        $data['module'] = $this->module;
        $data['parent_module'] = $this->parent_module;
        $data['parent'] = User::query()->findOrFail($user_id);
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

        $data['date_from'] = Carbon::parse(explode(' - ', $data['date'])[0])->toDateTimeString();
        $data['date_to'] = Carbon::parse(explode(' - ', $data['date'])[1])->toDateTimeString();

        $this->model::query()->updateOrCreate(['id' => $id], $data);

        return response()->json([
            'success' => TRUE,
            'message' => $id ? __('constants.success_update') : __('constants.success_add'),
        ]);
    }

}
