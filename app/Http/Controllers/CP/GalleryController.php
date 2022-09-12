<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\File;
use App\Models\Partner;
use App\Models\Setting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{
    private $model;
    private $module;
    public function __construct() {
        $this->model = new File();
        $this->module = 'galleries';
    }

    public function index() {
        Setting::query()->firstOrFail();
        $data['module'] = $this->module;
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list(Request $request) {
        $settings = Setting::query()->first();
        $items = $settings->files()->orderBy('created_at', 'DESC')->select('*');

        return Datatables::of($items)
            ->addColumn('actions', function ($item) {
                $delete = '<a href="javascript:;" class="dropdown-item" onclick="delete_items('.$item->id.', \''.route($this->module.'.delete').'\')">
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
            ->addColumn('check', function ($item) {
                return '<label class="checkbox" style="padding: 0">
                            <input type="checkbox" name="select[]" class="select" value="' . $item->id . '" style="display: none"/>
                            <span style="position: relative"></span>
                        </label>';
            })
            ->addColumn('image', function ($item) {
                return '<a href="'.$item->path.'" target="_blank"><img class="table-image" src="'.$item->path.'" alt="" style="max-width: 120px; max-height: 120px"></a>';
            })
            ->rawColumns(['actions', 'check', 'enabled', 'image', 'url'])
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
        return response()->json([
            'success' => TRUE,
            'page' => view('CP.'.$this->module.'.form', $data)->render()
        ]);
    }

    public function add_edit(Request $request) {
        if (isset($request['images']) && is_array($request['images']) && count($request['images'])) {
            foreach ($request['images'] as $image) {
                $settings = Setting::query()->first();
                $settings->files()->create([
                    'path' => upload_file($image, $this->module)
                ]);
            }
        }

        return response()->json([
            'success' => TRUE,
            'message' => __('constants.success_add'),
        ]);
    }

}
