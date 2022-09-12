<?php

namespace App\Http\Controllers\WS;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Interest;
use App\Models\Language;
use App\Models\User;
use App\Models\UsersDate;
use App\Models\UsersInterest;
use App\Models\UsersLanguage;
use App\Models\UsersMentorsRequest;
use App\Models\UsersVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login() {
        if (auth()->check())
            return redirect()->route('ws.home');
        return view('WS.login');
    }

    public function login_post(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email', Rule::exists('users', 'email')->where('verified', 1)->where('enabled', 1)->whereNull('deleted_at')],
            'password' => 'required|string',
        ]);
        if ($validate->fails()) {
            return back()->withInput()->with('errors', $validate->errors()->all())->with('error', 'Please check your email and password');
        }
        $user = User::query()->where('email', $request->email)->firstOrFail();
        if (Hash::check($request->password, $user->password)) {
            Auth::loginUsingId($user->getKey(), (boolean)$request->remember);
            return redirect()->route('ws.home')->with('success', 'Logged in successfully');
        }
        return back()->withInput()->with('error', 'Please check your email and password');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('ws.login');
    }

    public function forget_password() {
        if (auth()->check() && auth()->user()->type == 2)
            return redirect()->route('ws.home');
        return view('WS.users.forget_password');
    }

    public function forget_password_post(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email', Rule::exists('users', 'email')->where('type', 2)->where('verified', 1)->where('enabled', 1)->whereNull('deleted_at')],
        ]);
        if ($validate->fails()) {
            return back()->with('errors', $validate->errors()->all())->with('error', 'Email does not exist or not verified');
        }
        $user = User::query()->where('email', $request->email)->firstOrFail();
        $token = Str::random(30);
        UsersVerification::query()->create([
            'user_id' => $user->id,
            'email' => $user->email,
            'token' => $token
        ]);
        $link = route('ws.users.verify', ['token' => $token]);
        curl_email([$user->email], 'Al Sharq Executive Diploma Program', 'emails.forget_password', [
            'link' => $link,
            'name' => $user->name,
        ]);
        return redirect()->route('ws.login')->with('success', 'Please check your inbox');
    }

    public function verify($token) {
        $data['user'] = User::query()->whereHas('users_verifications', function ($q) use ($token) {
            $q->where('token', $token);
        })->where('type', 2)->where('enabled', 1)->firstOrFail();
        return view('WS.users.verify', $data);
    }

    public function verify_post(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|confirmed',
        ]);
        if ($validate->fails()) {
            return back()->with('errors', $validate->errors()->all())->with('error', 'Password is required and needs to be confirmed.');
        }
        $user = User::query()->where('email', $request->email)->where('id', $request->id)->where('type', 2)->firstOrFail();
        $user->update([
            'password' => bcrypt($request->password),
            'verified' => 1,
        ]);
        $user->users_verifications()->delete();
        session()->put('redirect_to_home', 1);
        Auth::loginUsingId($user->getKey(), true);
        return redirect()->route('ws.profile')->with('success', 'You have set your password and logged in successfully');
    }

    public function profile()
    {
        $data['countries'] = Country::query()->where('enabled', 1)->get();
        $data['interests'] = Interest::query()->where('enabled', 1)->get();
        $data['languages'] = Language::query()->where('enabled', 1)->get();
        return view('WS.users.profile', $data);
    }

    public function profile_post(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email', Rule::unique('users', 'email')->whereNull('deleted_at')->ignore(auth()->id())],
        ]);
        if ($validate->fails()) {
            return back()->with('errors', $validate->errors()->all())->with('error', 'The E-mail has been used before');
        }
        $user = User::query()->findOrFail(auth()->id());
        if ($request['name']) {
            $user->name = $request['name'];
        }
        if ($request['email']) {
            $user->email = $request['email'];
        }
        if ($request['gender']) {
            $user->gender = $request['gender'];
        }
        if ($request['country_id']) {
            $user->country_id = $request['country_id'];
        }
        if ($request->hasFile('image')) {
            $user->image = upload_file($request->file('image'), 'users');
        }
        $user->work = $request['work'];
        $user->study = $request['study'];
        $user->dob = $request['dob'];
        $user->bio = $request['bio'];
        $user->slack = $request['slack'];
        $user->facebook = $request['facebook'];
        $user->instagram = $request['instagram'];
        $user->twitter = $request['twitter'];
        $user->linkedin = $request['linkedin'];
        $user->extrovert = $request['extrovert'];
        $user->feeling = $request['feeling'];
        $user->intuition = $request['intuition'];
        $user->perceiving = $request['perceiving'];
        $user->maker = $request['maker'];
        $user->connector = $request['connector'];
        $user->idea_generator = $request['idea_generator'];
        $user->collaborator = $request['collaborator'];
        $user->finisher = $request['finisher'];
        $user->evaluator = $request['evaluator'];
        $user->organiser = $request['organiser'];
        $user->moderator = $request['moderator'];
        $user->save();

        UsersInterest::query()->where('user_id', auth()->id())->delete();
        foreach ((array)$request['interests'] as $interest_id) {
            UsersInterest::query()->create([
                'user_id' => auth()->id(),
                'interest_id' => $interest_id,
            ]);
        }

        UsersLanguage::query()->where('user_id', auth()->id())->delete();
        foreach ((array)$request['languages'] as $language_id) {
            UsersLanguage::query()->create([
                'user_id' => auth()->id(),
                'language_id' => $language_id,
            ]);
        }

        if ($request['old_password'] && $request['password']) {
            if (Hash::check($request['old_password'], $user->password)) {
                $user->password = bcrypt($request['password']);
                $user->save();
                return back()->with('success', 'Your password has been changed successfully');
            } else {
                return back()->with('warning', 'Your old password is incorrect, try again to reset your password')->with('success', 'Your information has been updated successfully');
            }
        }

        if (session()->has('redirect_to_home')) {
            session()->forget('redirect_to_home');
            return redirect()->route('ws.home')->with('success', 'Your information has been updated successfully');
        }
        return back()->with('success', 'Your information has been updated successfully');
    }

    public function user_profile($id)
    {
        $data['user'] = User::query()->findOrFail($id);
        return view('WS.users.user_profile', $data);
    }

    public function book_session(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => ['required', Rule::exists('users', 'id')->where('type', 3)],
            'date_id' => ['required', Rule::exists('users_dates', 'id')->where('user_id', $request['user_id'])]
        ]);
        if ($validate->fails()) {
            return back()->with('errors', $validate->errors()->all())->with('error', 'Invalid Data');
        }
        $date = UsersDate::query()->find($request['date_id']);
        UsersMentorsRequest::query()->create([
            'user_id' => auth()->id(),
            'mentor_id' => $request['user_id'],
            'date_from' => $date->date_from,
            'date_to' => $date->date_to,
        ]);
        return back()->with('success', 'You have booked a session successfully');
    }
}
