@foreach($messages as $message)
    @if($message->user)
        @php($for_me = isset($is_broadcast) && $is_broadcast ? false : $message->user_id == auth()->id())
        <div class="{{$for_me ? 'chaterMessage' : 'SenderMessageBox'}} d-block mb-3 message-{{$message->id}} chat-message-{{$for_me ? 'right' : 'left'}}">
            @if(!$for_me)
                <div class="d-flex">
                    <div class="chaterImg">
                        <img src="{{$message->user->full_path_image}}" alt="">
                    </div>
                    <div class="chaterDetails">
                        <div class="chaterDetailsHeader">
                            <h5>{{$message->user->name}}</h5>
                            @if($message->user->type == \App\Models\User::TYPE_LECTURER)
                                <span>@lang('ws.instructor')</span>
                            @endif
                        </div>
                        <div class="chatMessage">
                            <p>
                                @if($message->is_file)
                                    <a href="{{url($message->message)}}" target="_blank">
                                        <img src="{{url($message->message)}}" alt="" style="max-width: 200px; max-height: 200px">
                                    </a>
                                @else
                                    {!! $message->message !!}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            @if($for_me || auth()->user()->type == \App\Models\User::TYPE_ADMIN)
                <div class="deleteChatMessage delete_message" data-message_id="{{$message->id}}">
                    <i><img src="{{url('/')}}/ws_assets/images/Delete.svg" alt=""> </i>
                </div>
            @endif
            @if($for_me)
                <div class="chaterMessageBox">
                    <p>
                        @if($message->is_file)
                            <a href="{{url($message->message)}}" target="_blank">
                                <img src="{{url($message->message)}}" alt="" style="max-width: 200px; max-height: 200px">
                            </a>
                        @else
                            {!! $message->message !!}
                        @endif
                    </p>
                </div>
            @endif
            <div class="text-body small text-nowrap mt-2 text-{{locale() == 'ar' ? ($for_me ? 'left' : 'right') : ($for_me ? 'right' : 'left')}}">{{\Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</div>
        </div>
    @endif
@endforeach
