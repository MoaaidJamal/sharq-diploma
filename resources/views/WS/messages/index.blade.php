@extends('WS.layouts.main')

@section('title')
    @lang('ws.messages')
@endsection
@section('messages_active') active @endsection

@section('style')
    <style>
        .chat-messages {
            display: flex;
            flex-direction: column;
            height: 500px;
            overflow-y: scroll
        }

        .chat-message-left,
        .chat-message-right {
            display: flex;
            flex-shrink: 0
        }

        .chat-message-left {
            margin-right: auto
        }

        .chat-message-right {
            flex-direction: row-reverse;
            margin-left: auto
        }

        .py-3 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }

        .flex-grow-0 {
            flex-grow: 0 !important;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }

        .owner_message {
            background: #dcbcc3 !important;
        }

        .chat_link.active_chat {
            background: #e9ecef !important;
        }

        div.upload-file {
            position: relative;
            overflow: hidden;
        }
        div.upload-file input {
            position: absolute;
            font-size: 50px;
            opacity: 0;
            right: 0;
            top: 0;
        }
    </style>
@endsection

@section('body')

    @if(auth()->user()->chats()->count())
        <div class="card container rtl p-0">
            <div class="row g-0 chat_messages">
                <div class="col-12 col-lg-5 col-xl-3 border-right border-left">
                    @foreach($chats as $item)
                        <a href="javascript:;" class="list-group-item list-group-item-action border-0 chat_link {{$chat ? ($chat->id == $item->id ? 'active_chat' : '') : ($loop->first ? 'active_chat' : '')}}" data-chat_id="{{$item->id}}">
                            <div class="d-flex align-items-start py-1">
                                <img src="{{$item->phase ? $item->phase->image : $item->users()->where('users.id', '!=', auth()->id())->first()->full_path_image}}"
                                     class="rounded-circle mr-1" alt="" style="width: 40px; height:40px">
                                <div class="flex-grow-1 ml-3 py-2 px-3">
                                    {{$item->phase ? $item->phase->title : $item->users()->where('users.id', '!=', auth()->id())->first()->name}}
                                </div>
                            </div>
                        </a>
                    @endforeach

                    <hr class="d-block d-lg-none mt-1 mb-0">
                </div>
                @include('WS.messages.show', ['chat' => $chat ?? auth()->user()->chats()->first()])
            </div>
        </div>
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
            $('.chat_link').removeClass('active_chat');
            $(this).addClass('active_chat');
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
                        $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
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
