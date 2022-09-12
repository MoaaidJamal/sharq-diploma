<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index() {
        $data['settings'] = Setting::query()->firstOrFail();
        return view('CP/settings/index', $data);
    }

    public function update(Request $request){
        $data = $request->all();
        unset($data['_token']);

        if ($request->file('logo')) $data['logo'] = upload_file($request->file('logo'), 'settings');
        if ($request->file('icon')) $data['icon'] = upload_file($request->file('icon'), 'settings');
        if ($request->file('about_us_image')) $data['about_us_image'] = upload_file($request->file('about_us_image'), 'settings');
        if ($request->file('contact_us_image')) $data['contact_us_image'] = upload_file($request->file('contact_us_image'), 'settings');

        Setting::query()->update($data);

        return response()->json([
            'success'=> TRUE,
            'message'=> __('constants.success_update'),
        ]);
    }
}
