@foreach($messages as $message)
    @php($for_me = isset($is_broadcast) && $is_broadcast ? false : $message->user_id == auth()->id())
    <div class="chat-message-{{$for_me ? 'right' : 'left'}} pb-4 message-{{$message->id}}">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <img src="{{$message->user->full_path_image}}" class="rounded-circle mr-1" alt="" style="width: 40px; height:40px">
            <div class="text-body small text-nowrap mt-2">{{\Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</div>
        </div>
        <div class="flex-shrink-1 bg-light rtl {{$for_me ? 'owner_message' : ''}} rounded py-2 px-3 mx-3 d-flex flex-column">
            <div class="font-weight-bold mb-1 fw-bolder">{{$for_me ? 'You' : $message->user->name}}</div>
            @if($message->is_file)
                <a href="{{url($message->message)}}" target="_blank">
                    <img src="{{url($message->message)}}" alt="" style="max-width: 200px; max-height: 200px">
                </a>
            @else
                {!! $message->message !!}
            @endif
        </div>
        @if($for_me || auth()->user()->type == \App\Models\User::TYPE_ADMIN)
            <button class="btn text-danger delete_message" data-message_id="{{$message->id}}">X</button>
        @endif
    </div>
@endforeach
