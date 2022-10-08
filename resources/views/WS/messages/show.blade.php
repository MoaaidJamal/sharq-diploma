<div class="chatDetails chat_messages_container">
    <div class="chatTitle">
        {{$chat->phase ? $chat->phase->title : $chat->users()->where('users.id', '!=', auth()->id())->first()->name}}
    </div>
    <div class="chatBoxMessages chat-messages scrollable" data-chat_id="{{$chat->id}}">
        @include('WS.messages.messages', ['messages' => $chat->messages()->latest()->limit(20)->get()->reverse()])
    </div>
    <div class="replayChatBox">
        <form action="" class="replayChatForm">
            <input type="text" id="message" placeholder="Type your message" class="chatText">

            <div class="inputAttach upload-file">
                <label for="inputFileChat">
                    <input type="file" id="inputFileChat" name="file" accept="image/*" data-chat_id="{{$chat->id}}">
                    <i class="fa  fa-image"></i>
                </label>
            </div>

            <button type="submit" class="btn sendChatBtn send_message" data-chat_id="{{$chat->id}}">
                <i>
                    <img src="{{url('/')}}/ws_assets/images/send.svg" alt="">
                </i>
            </button>
        </form>
    </div>
</div>
<script>
    page = 2;
    $('.chat-messages').scroll(function () {
        if ($(this).scrollTop() == 0 && $(this).hasClass('scrollable')) {
            $.ajax({
                url: '{{route('ws.messages.get')}}?chat_id=' + $(this).data('chat_id') + '&page=' + page,
                type: 'get',
                success: function (data) {
                    if (data.success) {
                        if (data.end_of_messages) {
                            $('.chat-messages').removeClass('scrollable');
                        }
                        $('.chat-messages').scrollTop(50);
                        $('.chat-messages').prepend(data.page);
                        page++;
                    } else {
                        showAlertMessage('error', '@lang('constants.unknown_error')');
                    }
                }
            });
        }
    });
</script>
