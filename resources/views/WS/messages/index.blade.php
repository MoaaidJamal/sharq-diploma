@extends('WS.layouts.main')

@section('title')
    @lang('ws.messages')
@endsection
@section('messages_active') active @endsection

@section('style')
    <style>
    </style>
@endsection

@section('body')

    @if(auth()->user()->chats()->count())
        <section class="chatPageBody">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb chatbreadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('ws.home')</a></li>
                                <li class="breadcrumb-item active" aria-current="page">chat</li>
                            </ol>
                        </nav>
                        <div class="chatBox chat_messages">
                            <div class="chatSide">
                                <div class="chatCorner">
                                    <i><img src="{{url('/')}}/ws_assets/images/group.svg" alt=""></i>
                                </div>
                                <div class="chatMembers">
                                    <ul>
                                        @foreach($chats as $item)
                                            @php($user = $item->users()->where('users.id', '!=', auth()->id())->first())
                                            <li class="NoImgMember {{$chat ? ($chat->id == $item->id ? 'active' : '') : ($loop->first ? 'active' : '')}}">
                                                <a href="javascript:;" class="chat_link {{$chat ? ($chat->id == $item->id ? 'active_chat active' : '') : ($loop->first ? 'active_chat active' : '')}}" data-chat_id="{{$item->id}}">
                                                    <img src="{{$item->phase ? optional($item->phase)->image : ($user ? $user->full_path_image : '')}}" alt="">
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @include('WS.messages.show', ['chat' => $chat ?? auth()->user()->chats()->first()])
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="learning-path">
            <div class="container">
                <div class="alert alert-danger">No Available Chats</div>
            </div>
        </section>
    @endif

@endsection
@section('js')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        let page = 2;
        $('.chat_link').click(function () {
            $('.chat_link').removeClass('active_chat active');
            $('.chat_link').parent().removeClass('active');
            $(this).addClass('active_chat active');
            $(this).parent().addClass('active');
            let here = $(this);
            $.ajax({
                url: '{{route('ws.chat.show')}}?chat_id=' + $(this).data('chat_id'),
                type: 'get',
                beforeSend() {
                    blockPage({
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: '@lang('constants.please_wait') ...'
                    });
                },
                success: function (data) {
                    if (data.success) {
                        $('.chat_messages_container').remove();
                        $('.chat_messages').append(data.page);
                        $('.chat-messages').scrollTop($('.chat-messages')[0] ? $('.chat-messages')[0].scrollHeight : 0);
                        page = 2;
                    } else {
                        showAlertMessage('error', '@lang('constants.unknown_error')');
                    }
                    unblockPage();
                }
            })
        });
        $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
        $(document).on('keyup', '#message', function (e) {
            if ($(this).val() === '') {
                $('.send_message').attr('disabled', true);
            } else {
                $('.send_message').attr('disabled', false);
            }
        });
        $(document).on('click', '.send_message', function (e) {
            e.preventDefault();
            let here = $(this);
            $(this).attr('disabled', true);
            $.ajax({
                url: '{{route('ws.messages.store')}}',
                type: 'post',
                data: {
                    chat_id: $(this).data('chat_id'),
                    message: normalizeMessage($('#message').val()),
                    _token: '{{csrf_token()}}'
                },
                beforeSend() {
                    blockPage({
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: '@lang('constants.please_wait') ...'
                    });
                },
                success: function (data) {
                    if (data.success) {
                        $('.chat-messages').append(data.page);
                        $('#message').val('');
                        $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
                    } else {
                        showAlertMessage('error', '@lang('constants.unknown_error')');
                        here.attr('disabled', false);
                    }
                    unblockPage();
                }
            })
        });

        $(document).on('click', '.delete_message', function () {
            let here = $(this);
            $.ajax({
                url: '{{route('ws.messages.destroy')}}',
                type: 'post',
                data: {
                    message_id: $(this).data('message_id'),
                    _token: '{{csrf_token()}}'
                },
                beforeSend() {
                    blockPage({
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: '@lang('constants.please_wait') ...'
                    });
                },
                success: function (data) {
                    if (data.success) {
                        here.parents('.chat-message-right').remove();
                    } else {
                        showAlertMessage('error', '@lang('constants.unknown_error')');
                    }
                    unblockPage();
                }
            })
        });

        $(document).on('change', '.upload-file input', function () {
            let here = $(this);
            let data = new FormData();
            data.append('message', here[0].files[0]);
            data.append('chat_id', here.data('chat_id'));
            data.append('is_file', true);
            data.append('_token', $('meta[name="csrf-token"]').attr('content'));
            $.ajax({
                url: '{{route('ws.messages.store')}}',
                type: 'post',
                processData: false,
                contentType: false,
                data: data,
                beforeSend() {
                    blockPage({
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: '@lang('constants.please_wait') ...'
                    });
                },
                success: function (data) {
                    if (data.success) {
                        $('.chat-messages').append(data.page);
                        here.val('');
                        $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
                    } else {
                        showAlertMessage('error', '@lang('constants.unknown_error')');
                        here.attr('disabled', false);
                    }
                    unblockPage();
                }
            })
        });

        function normalizeMessage(message) {
            message = message.replace(/\n/g, '<br>');
            return message;
        }

        let pusher = new Pusher('249ba17e6a8412ca32f9', {
            cluster: 'ap2'
        });

        let channel = pusher.subscribe('chat');
        @foreach($chats as $item)
            channel.bind('message_to_chat_{{$item->id}}', function(data) {
                if (data.user_id != {{auth()->id()}}) {
                    $('.chat-messages[data-chat_id='+data.chat_id+']').append(data.page);
                    if ($('.chat-messages').scrollTop() < $('.chat-messages')[0].scrollHeight - 100) {
                        $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
                    }
                }
            });
            channel.bind('delete_message_from_chat_{{$item->id}}', function(data) {
                $('.message-' + data.message_id).remove();
            });
        @endforeach
    </script>
@endsection
