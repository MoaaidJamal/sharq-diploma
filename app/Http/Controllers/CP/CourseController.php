<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Course;
use App\Models\Phase;
use App\Models\User;
use App\Models\UsersChat;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    private $model;
    private $module;
    public function __construct() {
        $this->model = new Course();
        $this->module = 'courses';
    }

    public function index() {
        $data['module'] = $this->module;
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list(Request $request) {
        $items = $this->model::query()->WithMainPhase();

        if ($request['title'])
            $items->where('title->en', 'like', '%' . $request['title'] . '%')->orWhere('title->ar', 'like', '%' . $request['title'] . '%');

        $items->orderBy('order')->select('*');

        return Datatables::of($items)
            ->addColumn('actions', function ($item) {
                $details = '<a href="'.route($this->module.'.lectures', ['id' => $item->id]).'" class="dropdown-item">
                            <i class="flaticon-layers" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__($this->module.'.lectures').'</span>
                        </a>';
                $duplicate = '<a href="javascript:;" class="dropdown-item" onclick="showModal(\''.route($this->module.'.show_duplicate_form', ['id' => $item->id]).'\')">
                            <i class="flaticon-layers" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__($this->module.'.duplicate').'</span>
                        </a>';
                $edit = '<a class="dropdown-item" href="'.route($this->module.'.show_form', ['id' => $item->id]).'">
                            <i class="flaticon-edit" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.update').'</span>
                        </a>';
                $delete = '<a href="javascript:;" class="dropdown-item" onclick="delete_items('.$item->id.', \''.route($this->module.'.delete').'\')">
                            <i class="flaticon-delete" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.delete').'</span>
                        </a>';
                return '<div class="dropdown dropdown-inline">
                        <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="true">
                            <i class="la la-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            '.$details.'
                            '.$duplicate.'
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
            ->addColumn('is_available', function ($item) {
                $is_enabled = '';
                $is_enabled.='<div class="col-12">';
                $is_enabled.='<span class="switch">';
                $is_enabled.='<label style="margin: 5px 0 0">';
                $is_enabled.='<label style="margin: 0">';
                if($item->is_available) {
                    $is_enabled.='<input onclick="change_status(' . $item->id . ',\''.route($this->module.'.is_available').'\')" type="checkbox" checked="checked" name="">';
                } else {
                    $is_enabled.='<input onclick="change_status(' . $item->id . ',\''.route($this->module.'.is_available').'\')" type="checkbox" name="">';
                }
                $is_enabled .= '<span></span>';
                $is_enabled .= '</label>';
                $is_enabled .= '</div>';
                $is_enabled .= '</div>';
                return $is_enabled;
            })
            ->addColumn('title', function ($item) {
                return $item->title;
            })
            ->addColumn('phase_id', function ($item) {
                return optional($item->phase)->title ?: '-';
            })
            ->addColumn('image', function ($item) {
                return '<a href="'.$item->image.'" target="_blank"><img class="table-image" src="'.$item->image.'" alt="'.$item->{'name_'.locale()}.'" style="max-width: 120px; max-height: 120px"></a>';
            })
            ->addColumn('check', function ($item) {
                return '<label class="checkbox" style="padding: 0">
                            <input type="checkbox" name="select[]" class="select" value="' . $item->id . '" style="display: none"/>
                            <span style="position: relative"></span>
                        </label>';
            })
            ->rawColumns(['actions', 'check', 'enabled', 'image', 'is_available'])
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

    public function is_available(Request $request) {
        $id = $request->get('id');
        $item = $this->model::query()->find($id);

        if($item->is_available) {
            $item->is_available = 0;
            $item->save();
        } else {
            $item->is_available = 1;
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
        $data['phases'] = Phase::query()->get();
        $data['users'] = User::query()->where('type', 5)->get();
        if ($id) {
            $data['record'] = $this->model::query()->findOrFail($id);
        }
        return view('CP.'.$this->module.'.form', $data);
    }

    public function add_edit(Request $request) {
        $id = isset($request['id']) ? $request['id'] : null;
        $data = $request->toArray();
        unset($data['_token']);

        if ($request->hasFile('image')) $data['image'] = upload_file($request->file('image'), $this->module);

        if (!$id) {
            $data['order'] = $this->model::query()->max('order') + 1;
        }

        $course = $this->model::query()->updateOrCreate(['id' => $id], $data);

        if ($request->lectures_groups && is_array($request->lectures_groups) && count($request->lectures_groups)) {
            $ids = array_filter(Arr::pluck($request->lectures_groups, 'id'));
            if (count($ids)) {
                $course->all_lectures_groups()->whereNotIn('id', array_filter(Arr::pluck($request->lectures_groups, 'id')))->delete();
            }
            $i = 1;
            foreach ($request->lectures_groups as $item) {
                if ($item['title_ar'] && $item['title_en']) {
                    $course->all_lectures_groups()->updateOrCreate(['id' => $item['id'] ?? null], [
                        'title' => [
                            'ar' => $item['title_ar'],
                            'en' => $item['title_en'],
                        ],
                        'order' => $i
                    ]);
                    $i++;
                }
            }
        }

        return redirect()->route($this->module)->with('success', $id ? __('constants.success_update') : __('constants.success_add'));
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

    public function show_duplicate_form($id)
    {
        $data['module'] = $this->module;
        $data['record'] = null;
        $data['phases'] = Phase::query()->get();
        $data['id'] = $id;
        return response()->json([
            'success' => TRUE,
            'page' => view('CP.'.$this->module.'.duplicate_form', $data)->render()
        ]);
    }

    public function duplicate($id, Request $request) {
        duplicate_course($this->model::query()->findOrFail($id), $request->phase_id);
        return response()->json([
            'success' => TRUE,
            'message' => __($this->module . '.success_duplicate'),
        ]);
    }

}
