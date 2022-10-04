<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\Chat;
use App\Models\Country;
use App\Models\Course;
use App\Models\Interest;
use App\Models\Language;
use App\Models\Phase;
use App\Models\User;
use App\Models\UsersInterest;
use App\Models\UsersLanguage;
use App\Models\UsersPhase;
use App\Models\UsersVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    private $model;
    private $module;

    public function __construct() {
        $this->model = new User();
        $this->module = 'users';
    }

    public function index() {
        $data['module'] = $this->module;
        return view('CP.'.$this->module.'.index', $data);
    }

    public function list(Request $request) {
        $items = $this->model::query()->WithMainPhase();

        if ($request['name'])
            $items->where('name', 'like','%'.$request['name'].'%');

        if ($request['email'])
            $items->where('email', 'like','%'.$request['email'].'%');

        if ($request['mobile'])
            $items->where('mobile', 'like','%'.$request['mobile'].'%');

        if ($request['type'])
            $items->where('type', $request['type']);

        $items->where('id', '!=', 1)
            ->orderBy('created_at', 'DESC')
            ->select('*');

        return Datatables::of($items)
            ->addColumn('actions', function ($item) {
                $delete = '';
                $requests = '';
                $dates = '';
                $verification = '';
                $edit = '<a href="'.route($this->module.'.show_form', ['id' => $item->id]).'" class="dropdown-item">
                            <i class="flaticon-edit" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__('constants.show_update').'</span>
                        </a>';
                if ($item->type == 3) {
                    $requests = '<a href="'.route($this->module.'.sessions_requests', ['id' => $item->id]).'" class="dropdown-item">
                            <i class="flaticon-layers" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__($this->module.'.sessions_requests').'</span>
                        </a>';
                    $dates = '<a href="'.route($this->module.'.user_dates', ['id' => $item->id]).'" class="dropdown-item">
                            <i class="flaticon-clock-2" style="padding: 0 10px 0 13px;"></i>
                            <span style="padding-top: 3px">'.__($this->module.'.user_dates').'</span>
                        </a>';
                }
                if ($item->id != auth()->id()) {
                    $delete = '<a href="javascript:;" class="dropdown-item" onclick="delete_items('.$item->id.', \''.route($this->module.'.delete').'\')">
                                <i class="flaticon-delete" style="padding: 0 10px 0 13px;"></i>
                                <span style="padding-top: 3px">'.__('constants.delete').'</span>
                            </a>';
                }
                if ($item->type == 2 && !$item->verified) {
                    $verification = '<a href="javascript:;" class="dropdown-item" onclick="send_verification_link('.$item->id.')">
                                <i class="flaticon2-send-1" style="padding: 0 10px 0 13px;"></i>
                                <span style="padding-top: 3px">'.__($this->module.'.send_verification_link').'</span>
                            </a>';
                }
                return '<div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="true">
                                <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                '.$dates.'
                                '.$requests.'
                                '.$edit.'
                                '.$delete.'
                                '.$verification.'
                            </div>
                        </div>';
            })
            ->addColumn('enabled', function ($item) {
                if ($item->id != auth()->id()) {
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
                } else {
                    return '';
                }
            })
            ->addColumn('check', function ($item) {
                if ($item->id != auth()->id()) {
                    return '<label class="checkbox" style="padding: 0">
                            <input type="checkbox" name="select[]" class="select" value="' . $item->id . '" style="display: none"/>
                            <span style="position: relative"></span>
                        </label>';
                }
                return '';
            })
            ->addColumn('name', function ($item) {
                return $item->name;
            })
            ->addColumn('image', function ($item) {
                return '<a href="'.$item->full_path_image.'" target="_blank"><img class="table-image" src="'.$item->full_path_image.'" alt="'.$item->{'name_'.locale()}.'" style="max-width: 120px; max-height: 120px"></a>';
            })
            ->addColumn('type', function ($item) {
                if ($item->type == 1) {
                    return '<span class="badge badge-primary">' . __($this->module.'.admin') . '</span>';
                } elseif ($item->type == 2) {
                    return '<span class="badge badge-success">' . __($this->module.'.user') . '</span>';
                } elseif ($item->type == 3) {
                    return '<span class="badge badge-info">' . __($this->module.'.mentor') . '</span>';
                } elseif ($item->type == 4) {
                    return '<span class="badge badge-danger">' . __($this->module.'.team') . '</span>';
                } elseif ($item->type == 5) {
                    return '<span class="badge badge-secondary">' . __($this->module.'.lecturer') . '</span>';
                } else {
                    return '-';
                }
            })
            ->rawColumns(['actions', 'check', 'image', 'enabled', 'type'])
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
        $data['countries'] = Country::query()->get();
        $data['interests'] = Interest::query()->get();
        $data['languages'] = Language::query()->get();
        $data['phases'] = Phase::query()->get();
        $data['courses'] = Course::query()->get();
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

        if (isset($data['password']) && $data['password']) {
            $data['password'] = bcrypt($data['password']);
            $data['verified'] = 1;
        } else {
            unset($data['password']);
        }

        if ($request['type'] == 1) {
            $data['verified'] = 1;
        }

        if ($request->hasFile('image')) $data['image'] = upload_file($request->file('image'), $this->module);

        $user = $this->model::query()->updateOrCreate(['id' => $id], $data);

        if ($request['course_id'] && $user->type == 5) {
            Course::query()->whereKey($request['course_id'])->update(['user_id' => $user->getKey()]);
        }

        if (!$id && !$user->verified && $user->type == 2) {
            $token = Str::random(30);
            UsersVerification::query()->create([
                'user_id' => $user->getKey(),
                'email' => $user->email,
                'token' => $token
            ]);
            $link = route('ws.users.verify', ['token' => $token]);
            curl_email([$user->email], 'معلومات الدخول للموقع – الدبلوم التنفيذي', 'emails.user_verification', [
                'link' => $link,
                'name' => $user->name,
                'phase' => optional($user->phases()->first())->name ?: '-',
            ]);
        }

        UsersInterest::query()->where('user_id', $user->getKey())->delete();
        if (isset($request['interests']) && is_array($request['interests'])) {
            foreach ($request['interests'] as $item) {
                UsersInterest::query()->create([
                    'user_id' => $user->getKey(),
                    'interest_id' => $item
                ]);
            }
        }

        UsersLanguage::query()->where('user_id', $user->getKey())->delete();
        if (isset($request['languages']) && is_array($request['languages'])) {
            foreach ($request['languages'] as $item) {
                UsersLanguage::query()->create([
                    'user_id' => $user->getKey(),
                    'language_id' => $item
                ]);
            }
        }

        UsersPhase::query()->where('user_id', $user->getKey())->delete();
        if (isset($request['phases']) && is_array($request['phases'])) {
            foreach ($request['phases'] as $item) {
                UsersPhase::query()->create([
                    'user_id' => $user->getKey(),
                    'phase_id' => $item
                ]);
                $chat = Chat::query()->firstOrCreate(['phase_id' => $item]);
                $chat->users()->attach($user->getKey());
            }
        }

        return redirect()->route($this->module)->with('success', $id ? __('constants.success_update') : __('constants.success_add'));
    }

    public function check_unique(Request $request) {
        $id = isset($request['id']) ? $request['id'] : null;

        $errors = [];
        $users_email = $this->model::query();
        if ($id)
            $users_email = $users_email->where('id', '!=', $id);
        $users_email = $users_email->where('email', $request['email'])->count();

        if ($users_email) $errors[] = __($this->module.'.not_unique_email');

        if (count($errors)) {
            return response()->json([
                'success' => false,
                'errors' => $errors
            ]);
        } else {
            return response()->json([
                'success' => TRUE
            ]);
        }
    }

    public function send_verification_link(Request $request) {
        $user = $this->model::query()->find($request['id']);
        if ($user) {
            $token = Str::random(30);
            UsersVerification::query()->create([
                'user_id' => $user->id,
                'email' => $user->email,
                'token' => $token
            ]);
            $link = route('ws.users.verify', ['token' => $token]);
            curl_email([$user->email], 'Al Sharq Executive Diploma program | 2021-22 Cohort | Onboarding', 'emails.user_verification', [
                'link' => $link,
                'name' => $user->name,
                'phase' => optional($user->phases()->first())->name ?: '-',
            ]);
            return response()->json([
                'success'=> TRUE,
                'message'=> __($this->module.'.verification_sent_successfully')
            ]);
        }
        return response()->json([
            'success'=> FALSE
        ]);
    }

    public function import_users(Request $request) {
        if ($request->hasFile('file')) {
            Excel::import(new UsersImport, $request->file('file'));
            return response()->json([
                'success'=> TRUE,
                'message'=> __($this->module.'.imported_successfully')
            ]);
        }
        return response()->json([
            'success'=> FALSE
        ]);
    }

}
