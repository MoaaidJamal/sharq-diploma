<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\LecturesCategory;
use App\Models\LecturesGroup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use MacsiDigital\Zoom\Facades\Zoom;
use Yajra\DataTables\Facades\DataTables;

class LectureController extends Controller
{
    private $model;
    private $module;
    private $parent_module;
    public function __construct() {
        $this->model = new Lecture();
        $this->module = 'lectures';
        $this->parent_module = 'courses';
    }

    public function index($id) {
        $data['module'] = $this->module;
        $data['parent_module'] = $this->parent_module;
        $data['parent'] = Course::query()->findOrFail($id);
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list($id, Request $request) {
        $items = $this->model::query();

        if ($request['title'])
            $items->where('title->en', 'like', '%' . $request['title'] . '%')->orWhere('title->ar', 'like', '%' . $request['title'] . '%');

        $items->where('course_id', $id)->orderBy('order')->select('*');

        return Datatables::of($items)
            ->addColumn('actions', function ($item) use ($id) {
                $assignments = '';
                $users_attempts = '';
                $edit = '';
                if ($item->category_id == $this->model::CATEGORY_ASSIGNMENT) {
                    $assignments = '<a href="'.route($this->parent_module.'.'.$this->module.'.assignments', ['id' => $item->id]).'" href="javascript:;" class="dropdown-item">
                            <i class="flaticon-layers" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('assignments.title').'</span>
                        </a>';
                }
                if ($item->category_id == $this->model::CATEGORY_QUIZ) {
                    $users_attempts = '<a href="'.route($this->parent_module.'.'.$this->module.'.users_attempts', ['id' => $item->id]).'" class="dropdown-item">
                            <i class="flaticon-layers" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('users_attempts.title').'</span>
                        </a>';
                }
                if ($item->category_id != $this->model::CATEGORY_ZOOM) {
                    $edit = '<a href="'.route($this->parent_module.'.'.$this->module.'.show_form', ['course_id' => $id,'id' => $item->id]).'" class="dropdown-item">
                                <i class="flaticon-edit" style="padding: 0 10px 0 13px;"></i>
                                <span style="padding-top: 3px">'.__('constants.update').'</span>
                            </a>';
                } else {
                    $edit = '<a href="javascript:;" onclick="copyToClipboard(\'' . $item->join_url . '\')" class="dropdown-item">
                                <i class="flaticon2-copy" style="padding: 0 10px 0 13px;"></i>
                                <span style="padding-top: 3px">'.__($this->module.'.copy_url').'</span>
                            </a>';
                }
                $delete = '<a href="javascript:;" class="dropdown-item" onclick="delete_items('.$item->id.', \''.route($this->parent_module.'.'.$this->module.'.delete').'\')">
                            <i class="flaticon-delete" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.delete').'</span>
                        </a>';
                if ($edit || $delete || $users_attempts || $assignments) {
                    return '<div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="true">
                                <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                '.$assignments.'
                                '.$users_attempts.'
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
            ->addColumn('category_id', function ($item) {
                return '<span class="badge badge-'.Lecture::CATEGORIES_BADGE[$item->category_id].'">'.Lecture::CATEGORIES[$item->category_id].'</span>';
            })
            ->addColumn('title', function ($item) {
                return $item->title;
            })
            ->addColumn('lectures_group', function ($item) {
                return optional($item->lectures_group)->title;
            })
            ->addColumn('check', function ($item) {
                return '<label class="checkbox" style="padding: 0">
                            <input type="checkbox" name="select[]" class="select" value="' . $item->id . '" style="display: none"/>
                            <span style="position: relative"></span>
                        </label>';
            })
            ->rawColumns(['actions', 'check', 'enabled', 'category_id'])
            ->make(true);
    }

    public function delete(Request $request) {
        $lectures = $this->model::query()->whereIn('id', $request['ids'])->get();
        foreach ($lectures as $lecture) {
            if ($lecture->category_id == Lecture::CATEGORY_ZOOM && $lecture->meeting_id) {
                $meeting = Zoom::meeting()->find($lecture->meeting_id);
                if ($meeting) {
                    $meeting->delete();
                }
            }
            $lecture->delete();
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

    public function show_form($course_id, $id = null) {
        $data['module'] = $this->module;
        $data['parent_module'] = $this->parent_module;
        $data['groups'] = LecturesGroup::query()->where('course_id', $course_id)->get();
        $data['categories'] = LecturesCategory::query()->get();
        $data['parent'] = Course::query()->findOrFail($course_id);
        $data['record'] = null;
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
        if ($request->hasFile('file')) $data['file'] = upload_file($request->file('file'), $this->module);

        if ($data['date']) {
            $data['start_date'] = Carbon::parse(explode(' - ', $data['date'])[0])->toDateTimeString();
            $data['end_date'] = Carbon::parse(explode(' - ', $data['date'])[1])->toDateTimeString();
        }

        if (!$id) {
            $data['order'] = $this->model::query()->where('course_id', $data['course_id'])->max('order') + 1;
        }
        if ($request->category_id == Lecture::CATEGORY_ZOOM) {
            $meeting = createMeeting($request);
            $data['meeting_id'] = $meeting->id;
            $data['join_url'] = $meeting->join_url;
            $data['start_url'] = $meeting->start_url;

            $course = Course::query()->find($data['course_id']);
            $emails = array_filter(User::query()->whereHas('phasesPivot', function ($q) use ($course) {
                $q->where('phase_id', $course->phase_id);
            })->pluck('email')->toArray());
            curl_email($emails, 'New live lecture about ' . $request->title['en'], 'emails.zoom_meeting', [
                'link' => $meeting->join_url,
                'date' => $data['start_date'],
                'title' => $request->title['en'],
            ]);
        }

        $lecture = $this->model::query()->updateOrCreate(['id' => $id], $data);

        if ($request->quiz_questions && is_array($request->quiz_questions) && count($request->quiz_questions)) {
            $ids = array_filter(Arr::pluck($request->quiz_questions, 'id'));
            if (count($ids)) {
                $lecture->questions()->whereNotIn('id', array_filter(Arr::pluck($request->quiz_questions, 'id')))->delete();
            }
            $i = 1;
            foreach ($request->quiz_questions as $item) {
                if ($item['question'] && $item['answer1'] && $item['answer2'] && $item['correct_answer']) {
                    $lecture->questions()->updateOrCreate(['id' => $item['id'] ?? null], [
                        'question' => $item['question'],
                        'answer1' => $item['answer1'],
                        'answer2' => $item['answer2'],
                        'answer3' => $item['answer3'] ?? null,
                        'answer4' => $item['answer4'] ?? null,
                        'correct_answer' => $item['correct_answer'],
                        'order' => $i
                    ]);
                    $i++;
                }
            }
        }

        return redirect()->route($this->parent_module.'.'.$this->module, ['id' => $request['course_id']])->with('success', $id ? __('constants.success_update') : __('constants.success_add'));
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
