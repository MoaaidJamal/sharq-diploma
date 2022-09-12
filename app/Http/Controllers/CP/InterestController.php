<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Interest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InterestController extends Controller
{
    private $model;
    private $module;
    public function __construct() {
        $this->model = new Interest();
        $this->module = 'interests';
    }

    public function index() {
        $data['module'] = $this->module;
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list(Request $request) {
        $items = $this->model::query();

        if ($request['name'])
            $items->where('name->en', 'like', '%' . $request['name'] . '%')->orWhere('name->ar', 'like', '%' . $request['name'] . '%');

        $items->orderBy('created_at', 'DESC')->select('*');

        return Datatables::of($items)
            ->addColumn('actions', function ($item) {
                $edit = '<a href="javascript:;" class="dropdown-item" onclick="showModal(\''.route($this->module.'.show_form', ['id' => $item->id]).'\')">
                            <i class="flaticon-edit" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.update').'</span>
                        </a>';
                $delete = '<a href="javascript:;" class="dropdown-item" onclick="delete_items('.$item->id.', \''.route($this->module.'.delete').'\')">
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
                    $is_enabled.='<input onclick="change_status(' . $item->id . ',\''.route($this->module.'.status').'\')" type="checkbox" checked="checked" name="">';
                } else {
                    $is_enabled.='<input onclick="change_status(' . $item->id . ',\''.route($this->module.'.status').'\')" type="checkbox" name="">';
                }
                $is_enabled .= '<span></span>';
                $is_enabled .= '</label>';
                $is_enabled .= '</div>';
                $is_enabled .= '</div>';
                return $is_enabled;
            })
            ->addColumn('name', function ($item) {
                return $item->name;
            })
            ->addColumn('check', function ($item) {
                return '<label class="checkbox" style="padding: 0">
                            <input type="checkbox" name="select[]" class="select" value="' . $item->id . '" style="display: none"/>
                            <span style="position: relative"></span>
                        </label>';
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

        $this->model::query()->updateOrCreate(['id' => $id], $data);

        return response()->json([
            'success' => TRUE,
            'message' => $id ? __('constants.success_update') : __('constants.success_add'),
        ]);
    }

}
