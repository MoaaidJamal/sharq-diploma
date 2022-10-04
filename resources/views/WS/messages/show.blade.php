<div class="col-12 col-lg-7 col-xl-9 chat_messages_container" style="direction: ltr">
    <div class="py-2 px-4 border-bottom d-none d-lg-block">
        <div class="d-flex align-items-center py-1">
            <div class="position-relative">
                <img src="{{$chat->phase ? $chat->phase->image : $chat->users()->where('users.id', '!=', auth()->id())->first()->full_path_image}}" class="rounded-circle mr-1" alt="" style="width: 40px; height:40px">
            </div>
            <div class="flex-grow-1 pl-3 px-3">
                <strong>{{$chat->phase ? $chat->phase->title : $chat->users()->where('users.id', '!=', auth()->id())->first()->name}}</strong>
            </div>
        </div>
    </div>

    <div class="position-relative">
        <div class="chat-messages scrollable p-4" data-chat_id="{{$chat->id}}">
            @include('WS.messages.messages', ['messages' => $chat->messages()->latest()->limit(20)->get()->reverse()])
        </div>
    </div>

    <div class="flex-grow-0 py-3 px-4 border-top">
        <div class="input-group">
            <div class="upload-file btn btn-lg btn-success p-3">
                <i class="bi bi-card-image"></i>
                <input type="file" name="file" accept="image/*" data-chat_id="{{$chat->id}}" style="cursor: pointer"/>
            </div>
            <textarea id="message" class="form-control" placeholder="Type your message"></textarea>
            <button class="btn btn-primary send_message" disabled data-chat_id="{{$chat->id}}">@lang('ws.send')</button>
        </div>
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
