<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Phase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PhaseController extends Controller
{
    private $model;
    private $module;
    public function __construct() {
        $this->model = new Phase();
        $this->module = 'phases';
    }

    public function index() {
        $data['module'] = $this->module;
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list(Request $request) {
        $items = $this->model::query();

        if ($request['name'])
            $items->where('name', 'like','%'.$request['name'].'%');

        $items->orderBy('order')->select('*');

        return Datatables::of($items)
            ->addColumn('actions', function ($item) {
                $duplicate = '<a href="javascript:;" class="dropdown-item" onclick="duplicate(\''.route($this->module.'.duplicate', ['id' => $item->id]).'\')">
                            <i class="flaticon-layers" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__($this->module.'.duplicate').'</span>
                        </a>';
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
                                '.$duplicate.'
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
            ->addColumn('check', function ($item) {
                return '<label class="checkbox" style="padding: 0">
                            <input type="checkbox" name="select[]" class="select" value="' . $item->id . '" style="display: none"/>
                            <span style="position: relative"></span>
                        </label>';
            })
            ->addColumn('image', function ($item) {
                return '<a href="'.$item->image.'" target="_blank"><img class="table-image" src="'.$item->image.'" alt="'.$item->{'name_'.locale()}.'" style="max-width: 120px; max-height: 120px"></a>';
            })
            ->addColumn('title', function ($item) {
                return $item->title;
            })
            ->rawColumns(['actions', 'check', 'enabled', 'image'])
            ->make(true);
    }

    public function delete(Request $request) {
        $phases = $this->model::query()->whereIn('id', $request['ids'])->get();
        foreach ($phases as $phase) {
            $phase->chats()->delete();
            $phase->delete();
        }
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
        $data['phases'] = Phase::query()->whereKeyNot($id)->get();
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

        if (!$id) {
            $data['order'] = $this->model::query()->max('order') + 1;
        }

        if ($request->hasFile('image')) $data['image'] = upload_file($request->file('image'), $this->module);

        $phase = $this->model::query()->updateOrCreate(['id' => $id], $data);

        $chat = Chat::query()->firstOrCreate(['phase_id' => $phase->id]);
        $chat->users()->sync($phase->usersPivot()->pluck('user_id')->toArray());

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

    public function duplicate($id) {
        $phase = $this->model::query()->findOrFail($id);
        $new_phase = $phase->replicate();
        $new_phase->title = [
            'ar' => $new_phase->getTranslation('title', 'ar') . ' - (نسخة)',
            'en' => $new_phase->getTranslation('title', 'en') . ' - (Copy)',
        ];
        $new_phase->order = ($phase->order ?: 0) + 1;
        $new_phase->save();
        foreach ($phase->courses ?? [] as $course) {
            duplicate_course($course, $new_phase->getKey());
        }
        foreach ($phase->chats as $chat) {
            $new_chat = $chat->replicate();
            $new_chat->phase_id = $new_phase->getKey();
            $new_chat->save();
            $new_chat->users()->sync($chat->users()->pluck('user_id')->toArray());
        }
        return response()->json([
            'success' => TRUE,
            'message' => __($this->module . '.success_duplicate'),
        ]);
    }

}
