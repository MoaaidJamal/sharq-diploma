<?php

namespace App\Http\Controllers\WS;

use App\Events\DeleteMessage;
use App\Events\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Course;
use App\Models\Interest;
use App\Models\Partner;
use App\Models\Slider;
use App\Models\User;
use App\Models\UsersChat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['sliders'] = Slider::query()->where('enabled', 1)->whereIn('phase_id', userPhases())->exists() ? Slider::query()->where('enabled', 1)->whereIn('phase_id', userPhases())->get() : Slider::query()->whereNull('phase_id')->where('enabled', 1)->get();
        $data['partners'] = Partner::query()->where('enabled', 1)->get();
        $data['courses'] = Course::query()->whereIn('phase_id', userPhases())->where('enabled', 1)->get();
        $data['gallery'] = settings_row()->files->take(6);
        $data['mates'] = User::query()->InMyPhases()->whereKeyNot(auth()->id())->limit(8)->where('type', 2)->where('enabled', 1)->where('verified', 1)->get();
        $data['mentors'] = User::query()->InMyPhases()->limit(8)->where('type', 3)->where('enabled', 1)->get();
        $data['team'] = User::query()->InMyPhases()->where('type', 4)->where('enabled', 1)->get();
        return view('WS.home', $data);
    }

    public function gallery()
    {
        $data['images'] = settings_row()->files;
        return view('WS.gallery', $data);
    }

    public function teammates($interest_id = null)
    {
        $data['mates'] = User::query()->when($interest_id, function ($q) use ($interest_id) {
            $q->whereHas('user_interests', function ($q) use ($interest_id) {
                $q->where('interest_id', $interest_id);
            });
        })->InMyPhases()->whereKeyNot(auth()->id())->where('type', 2)->where('enabled', 1)->where('verified', 1)->paginate(12);
        $data['interests'] = Interest::query()->where('enabled', 1)->get();
        $data['interest_id'] = $interest_id;
        return view('WS.teammates', $data);
    }

    public function mentors()
    {
        $data['mentors'] = User::query()->InMyPhases()->whereKeyNot(auth()->id())->where('type', 3)->where('enabled', 1)->paginate(12);
        return view('WS.mentors', $data);
    }

    public function schedule()
    {
        $data['courses'] = Course::query()
            ->whereIn('phase_id', userPhases())
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('enabled', 1)
            ->get();
        return view('WS.schedule', $data);
    }

    public function modules()
    {
        $data['courses'] = Course::query()->whereIn('phase_id', userPhases())->where('enabled', 1)->get();
        return view('WS.courses.index', $data);
    }

    public function start_chat($id, Request $request)
    {
        if ($request->is_course) {
            $course = Course::query()->findOrFail($id);
            $chat = Chat::query()->where('phase_id', $id)->first();
            if (!$chat) {
                $chat = Chat::query()->create([
                    'phase_id' => $id,
                ]);
                UsersChat::query()->create([
                    'user_id' => auth()->id(),
                    'chat_id' => $chat->id,
                ]);
                UsersChat::query()->create([
                    'user_id' => $course->user_id,
                    'chat_id' => $chat->id,
                ]);
            } else {
                UsersChat::query()->firstOrCreate([
                    'user_id' => auth()->id(),
                    'chat_id' => $chat->id,
                ]);
                UsersChat::query()->firstOrCreate([
                    'user_id' => $course->user_id,
                    'chat_id' => $chat->id,
                ]);
            }
        } else {
            $chat = Chat::query()->whereHas('users', function ($q) use ($id) {
                $q->where('users.id', auth()->id())->where('users.id', $id);
            })->first();
            if (!$chat) {
                $chat = Chat::query()->create();
                UsersChat::query()->create([
                    'user_id' => auth()->id(),
                    'chat_id' => $chat->id,
                ]);
                UsersChat::query()->create([
                    'user_id' => $id,
                    'chat_id' => $chat->id,
                ]);
            }
        }
        return redirect()->route('ws.messages', ['id' => $chat->id]);
    }

    public function messages($id = null)
    {
        $data['chats'] = Chat::with('messages')->whereHas('users', function ($q) {
            $q->where('users.id', auth()->id());
        })->orderBy('created_at', 'desc')->get();
        $data['chat'] = null;
        if ($id) {
            $data['chat'] = Chat::query()->whereHas('users', function ($q) use ($id) {
                $q->whereIn('users.id', [auth()->id(), $id]);
            })->findOrFail($id);
        }
        return view('WS.messages.index', $data);
    }

    public function show_chat(Request $request)
    {
        $data['chat'] = Chat::query()->whereHas('users', function ($q) use ($request) {
            $q->where('users.id', auth()->id());
        })->findOrFail($request->chat_id);
        return response()->json([
            'success' => true,
            'page' => view('WS.messages.show', $data)->render()
        ]);
    }

    public function get_messages(Request $request)
    {
        $chat = Chat::query()->whereHas('users', function ($q) {
            $q->where('users.id', auth()->id());
        })->findOrFail($request->chat_id);
        $paginate = ChatMessage::query()->where('chat_id', $chat->id)->latest()->paginate(20);
        $data['messages'] = collect($paginate->items())->reverse();
        return response()->json([
            'success' => true,
            'end_of_messages' => $paginate->lastPage() <= $paginate->currentPage(),
            'page' => view('WS.messages.messages', $data)->render(),
        ]);
    }

    public function store_message(Request $request)
    {
        if ($request->message && $request->chat_id) {
            $data['messages'][] = ChatMessage::query()->create([
                'chat_id' => $request->chat_id,
                'user_id' => auth()->id(),
                'message' => $request->is_file && $request->hasFile('message') ? upload_file($request->message, 'chats') : $request->message,
                'is_file' => !!$request->is_file,
            ]);
            event(new SendMessage($request->chat_id, auth()->id(), view('WS.messages.messages', array_merge($data, ['is_broadcast' => true]))->render()));
            return response()->json([
                'success' => true,
                'chat_id' => $request->chat_id,
                'page' => view('WS.messages.messages', $data)->render()
            ]);
        }
        return response()->json([
            'success' => false,
        ]);
    }

    public function delete_message(Request $request)
    {
        if ($request->message_id) {
            $message = ChatMessage::query()->when(auth()->user()->type != User::TYPE_ADMIN, function ($q) {
                $q->where('user_id', auth()->id());
            })->findOrFail($request->message_id);
            event(new DeleteMessage($request->message_id, $message->chat_id));
            $message->delete();
            return response()->json([
                'success' => true,
            ]);
        }
        return response()->json([
            'success' => false,
        ]);
    }
}
