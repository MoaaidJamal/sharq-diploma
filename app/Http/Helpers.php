<?php

use App\Helpers\APIResponse;
use App\Models\Lecture;
use App\Models\Phase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use MacsiDigital\Zoom\Facades\Zoom;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

function api($success, $code, $message, $items = null, $errors = null)
{
    return new APIResponse($success, $code, $message);
}

function localURL($url)
{
    return url(app()->getLocale() . '/' . $url);
}

function locale()
{
    return app()->getLocale();
}

function direction()
{
    return locale() == 'ar' ? '.rtl' : '';
}

function isRTL()
{
    return locale() == 'ar';
}

function get_location_name($point)
{
    $location = $point;//31.52438463733194,34.445425383746624
    $api_key = 'AIzaSyBrWglZENOn9R8_AXpLxGUMiwWo3DyMelI';
    $radius = 1000;
    $location_name = '';
    $photo = '';

    $url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=' . $location . '&language=' . locale() . '&radius=' . $radius . '&key=' . $api_key;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, false);
    curl_setopt($curl, CURLOPT_POST, 0);
    curl_setopt($curl, CURLOPT_HTTPGET, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Accept: application/json'));
    $result = curl_exec($curl);
    $err_in = curl_error($curl);
    curl_close($curl);
    $result = json_decode($result, true);

    if (isset($result['results']) && sizeof($result['results']) > 0) {
        if (isset($result['results'][0]['name']))
            $location_name .= $result['results'][0]['vicinity'];

        if (isset($result['results'][0]['name']))
            $location_name = $result['results'][0]['name'];
        $photo = $result['results'][0]['photos'][0]['photo_reference'];
    }

    return [
        'location' => $location_name,
        'photo' => 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=' . $photo . '&key=' . $api_key
    ];
}

function cleanText($text) {
    return trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($text))))));
}

function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "M") {
        return round(($miles * 1.609344), 3);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return miles_to_meters($miles);
    }
}

function miles_to_meters($miles)
{
    return $miles * 1.60934 * 1000;
}

function upload_file($file, $folder)
{
    $ex = $file->getClientOriginalExtension();
    return 'uploads/' . $file->storeAs($folder, time() . Str::random(30) . '.' . $ex);
}

function language($en, $ar)
{
    return app()->getLocale() == 'ar' ? $ar : $en;
}

function check_permission($name)
{
    if (auth()->check()) {
        if (auth()->user()->type == User::TYPE_ADMIN) {
            return collect(auth()->user()->permissions)->contains($name) || auth()->id() == 1;
        } else if (in_array($name, ['user_grades', 'user_assignments', 'users_quizzes'])) {
            return true;
        }
    } else {
        return false;
    }
}

function check_group_permission($pid, $gid)
{
    $permission = Permission::query()->where('guard_name', 'web')->find($pid);
    return Role::query()->where('guard_name', 'web')->find($gid)->hasPermissionTo($permission);
}

function check_user_group($uid, $gid)
{
    $item = \App\Models\Admin::query()->find($uid);
    return $item && $item->admin_roles ? $item->admin_roles->contains('role_id', $gid) : false;
}

function check_user_direct_permission($pid, $uid)
{
    $item = \App\Models\Admin::query()->find($uid);
    return $item && $item->admin_permissions ? $item->admin_permissions->contains('permission_id', $pid) : false;
}

function settings_row()
{
    return \App\Models\Setting::query()->first();
}

function settings($key)
{
    return \App\Models\Setting::query()->first()->{$key};
}

function payment($amount, $user, $order)
{
    $idorder = 'PHP_' . rand(1, 1000);//Customer Order ID

    $terminalId = "itve";// Will be provided by URWAY
    $password = "itve@URWAY_123";// Will be provided by URWAY
    $merchant_key = "8a8af549bf09664d87f187ddd37668a04499ef8aa70e32d764ba38259fe9e105";// Will be provided by URWAY
    $currencycode = "SAR";

    function get_server_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    $ipp = '178.63.103.183';
    //Generate Hash
    $txn_details= $idorder.'|'.$terminalId.'|'.$password.'|'.$merchant_key.'|'.$amount.'|'.$currencycode;
    $hash=hash('sha256', $txn_details);


    $fields = array(
        'trackid' => $idorder,
        'terminalId' => $terminalId,
        'customerEmail' => $user->email ?? 'test@test.com',
        'action' => "1",  // action is always 1
        'merchantIp' =>$ipp,
        'password'=> $password,
        'currency' => $currencycode,
        'country'=>"SA",
        'amount' => $amount,
        "udf1"              =>$order->id,
        "udf2"              =>route('api.payment_response'),//Response page URL
        "udf3"              =>"",
        "udf4"              =>"",
        "udf5"              =>"",
        'requestHash' => $hash  //generated Hash
    );
    $data = json_encode($fields);
 	$ch=curl_init('https://payments.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest'); // Will be provided by URWAY
// 	$ch=curl_init('https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest'); // Will be provided by URWAY
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $server_output =curl_exec($ch);
    curl_close($ch);
    $result = json_decode($server_output);
    $response = [
        'url' => null,
        'invoice_id' => null,
    ];
    if (!empty($result->payid) && !empty($result->targetUrl)) {
        $response['url'] = $result->targetUrl . '?paymentid=' .  $result->payid;
        $response['invoice_id'] = $result->payid;
    }
    return $response;
}

function sms($mobile, $msg) {
    $user = 'Breathing';
    $password = '123456';
    $sender = 'Breathing';
    $text = urlencode( $msg);
    $to = $mobile;
    $url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sender&unicode=E&return=full";
    file_get_contents($url);
}

function curl_email($emails, $subject, $view, $date){
    $data['_token'] = csrf_token();
    $data['view'] = $view;
    $data['date'] = $date;
    $data['subject'] = $subject;
    $data['emails'] = $emails;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, route('send_curl_mails'));
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
    ));
    try {
        $result = curl_exec($curl);
        $err_in = curl_error($curl);
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error($e->getMessage());
    }
    curl_close($curl);
}

function userPhases() {
    if (auth()->check()) {
        if (auth()->id() == 1 || auth()->user()->type == User::TYPE_ADMIN) {
            return Phase::query()->pluck('id')->toArray();
        } else {
            return auth()->user()->phasesPivot()->pluck('phase_id')->toArray();
        }
    }
    return [];
}

function createMeeting($request) {
    config(['zoom' => array_merge(config('zoom'), Lecture::ZOOM_ACCOUNTS[$request->zoom_account])]);

    $user = Zoom::user()->first();

    $meeting = Zoom::meeting()->make([
        'topic' => $request->title['en'],
        'duration' => $request->minutes,
        'start_time' => $request->start_time,
        'timezone' => config('zoom.timezone')
    ]);

    $meeting->settings()->make([
        'join_before_host' => false,
        'host_video' => false,
        'participant_video' => false,
        'mute_upon_entry' => true,
        'waiting_room' => true,
        'approval_type' => config('zoom.approval_type'),
        'audio' => config('zoom.audio'),
        'auto_recording' => config('zoom.auto_recording')
    ]);

    return $user->meetings()->save($meeting);
}

function duplicate_course($course, $phase_id) {
    DB::beginTransaction();
    $new_course = $course->replicate();
    $new_course->phase_id = $phase_id;
    $new_course->title = [
        'ar' => $new_course->getTranslation('title', 'ar') . ' - (نسخة)',
        'en' => $new_course->getTranslation('title', 'en') . ' - (Copy)',
    ];
    $new_course->order = ($course->order ?: 0) + 1;
    $new_course->save();
    foreach ($course->all_lectures_groups ?? [] as $lecture_group) {
        $new_lecture_group = $lecture_group->replicate();
        $new_lecture_group->course_id = $new_course->getKey();
        $new_lecture_group->save();
        foreach ($lecture_group->lectures ?? [] as $lecture) {
            $new_lecture = $lecture->replicate();
            $new_lecture->group_id = $new_lecture_group->getKey();
            $new_lecture->course_id = $new_course->getKey();
            $new_lecture->save();
            foreach ($lecture->questions ?? [] as $question) {
                $new_question = $question->replicate();
                $new_question->lecture_id = $new_lecture->getKey();
                $new_question->save();
            }
        }
    }
    foreach ($course->lectures()->whereDoesntHave('lectures_group')->get() as $lecture) {
        $new_lecture = $lecture->replicate();
        $new_lecture->course_id = $new_course->getKey();
        $new_lecture->save();
        foreach ($lecture->questions ?? [] as $question) {
            $new_question = $question->replicate();
            $new_question->lecture_id = $new_lecture->getKey();
            $new_question->save();
        }
    }
    DB::commit();
}
