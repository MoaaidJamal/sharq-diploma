@extends('WS.layouts.main')

@section('title') @lang('ws.module') - {{$course->title}} @endsection
@section('modules_active') active @endsection
@section('style')
    <link href="{{url('/')}}/ws_assets/css/lessonpage.css" rel="stylesheet" />
    <link href="{{url('/')}}/ws_assets/css/Lessonassignment.css" rel="stylesheet" />
    <link href="{{url('/')}}/ws_assets/css/userprofile.css" rel="stylesheet" />
    <link href="{{url('/')}}/ws_assets/css/course.css" rel="stylesheet" />
    <style>
        #submit_btn {
            background-color: #9B3B5A;
            padding: 0 2rem;
            height: 40px;
            color: #fff;
            min-width: 200px;
            width: auto;
        }
    </style>
@endsection

@section('body')

    <section class="two-progress" data-aos="fade-down">
        <div class="container rtl">
            <div class="row info-box px-4 justify-content-between">
                <div class="d-flex flex-column justify-content-center pt-3">
                    <div class="tc-gray xs-small d-flex align-items-center">@lang('ws.module_progress_bar')</div>
                    <div class="font-inter font-bold700 progress-text">{{$course->title}}</div>
                    <div class="mb-3">
                        <div class="budget-wrap">
                            <div class="budget d-flex flex-column-reverse">
                                <div class="header d-flex justify-content-between">
                                    <div class="font-bold700 font-inter text-prog">@lang('ws.your_score') (<span class="pull-right" id="course"></span>)</div>
                                </div>
                                <div class="content" style="direction: ltr;">
                                    <input type="range" id="range-course" min="0" max="100" value="{{$course->getUserScore()}}" data-rangeslider disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="d-flex flex-column align-items-center" data-aos="fade-down">
        <div class="container my-5">
            <div class="d-flex justify-content-between">
                <h2 class="font-inter font-bold700 rtl">{{$course->title}}</h2>
{{--                <a href="{{route('ws.start_chat', ['id' => $course->id])}}?is_course=1" class="btn btn-primary btn-lg">@lang('ws.go_to_chat')</a>--}}
            </div>
            <div class="my-2 rtl">
                <span class="font-inter font-bold700 xs-small">{{$course->getLecturesCount()}} @lang('ws.lectures')</span>
                <span class="font-inter font-bold700 xs-small tc-gray"><i class="bi bi-dot"></i>{{$course->hours ?? 0}} @lang('ws.hours')</span>
            </div>
            <div class="row justify-content-between">
                <!-- Left Box -->
                <div class="col-lg-8">
                    <div>
                        @if(!in_array($lecture->category_id, [\App\Models\Lecture::CATEGORY_QUIZ, \App\Models\Lecture::CATEGORY_ZOOM]))
                            <div>
                                @if($lecture->embedded_code)
                                    <div>
                                        {!! $lecture->embedded_code !!}
                                    </div>
                                @else
                                    @if($lecture->file_type == 1)
                                        <iframe width="100%" height="500px" src="https://www.youtube.com/embed/{{$lecture->video_id}}"></iframe>
                                    @elseif($lecture->file_type == 2)
                                        <iframe width="100%" height="500px" src="https://player.vimeo.com/video/{{$lecture->video_id}}"></iframe>
                                    @elseif($lecture->file_type == 3)
                                        <iframe src="{{$lecture->file}}" width="100%" height="500px" frameborder="0" type="application/pdf"></iframe>
                                    @elseif($lecture->file_type == 4)
                                        <iframe src="https://docs.google.com/gview?url={{$lecture->file}}&embedded=true" width="100%" height="500px" frameborder="0"></iframe>
                                    @elseif($lecture->file_type == 5)
                                        <div style="width: 100%; height:500px; overflow-y: auto">
                                            {!! $lecture->content !!}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endif
                        @if($lecture->category_id == \App\Models\Lecture::CATEGORY_ZOOM)
                            <h3>@lang('ws.this_live_lecture'): {{\Carbon\Carbon::parse($lecture->start_date)->toDateTimeString()}}</h3>
                            @lang('ws.joining_link'): <a href="{{$lecture->join_url}}" target="_blank">{{$lecture->join_url}}</a>
                        @endif
                        @if($lecture->description)
                            <div class="mb-4 rtl">
                                <div class="font-inter font-bold700 my-4">@lang('ws.about') @if($lecture->category_id == \App\Models\Lecture::CATEGORY_QUIZ) @lang('ws.quiz') @elseif($lecture->category_id == \App\Models\Lecture::CATEGORY_ASSIGNMENT) @lang('ws.assignment') @else @lang('ws.lecture') @endif</div>
                                {!! $lecture->description !!}
                            </div>
                        @endif
                    </div>
                    @if($lecture->category_id == \App\Models\Lecture::CATEGORY_ASSIGNMENT && $lecture->assignment)
                        @if(\Carbon\Carbon::parse($lecture->start_date)->lt(now()) && \Carbon\Carbon::parse($lecture->end_date)->gt(now()))
                            <div class="rtl">
                                <h4 class="font-inter font-bold700 my-3">@lang('ws.assignment'):</h4>
                                <div class="d-flex flex-column mb-4">
                                    <div class="font-inter font-bold700 small">
                                        {!! $lecture->assignment !!}
                                    </div>
                                </div>
                                @if($assignment)
                                    <div class="row mb-3" style="padding: 20px 10px; background: #efefef; border-radius: 10px">
                                        <h5>@lang('ws.you_submitted_file')</h5>
                                        <h6 style="margin: 0;">@lang('ws.your_submitted_file'): &nbsp  <a href="{{$assignment->file}}" class="btn btn-secondary" download="{{$assignment->file_name}}">@lang('ws.your_file')</a></h6>
                                    </div>
                                @endif
                                <div class="row mb-3" style="padding: 20px 10px; background: #efefef; border-radius: 10px">
                                    <form action="{{route('ws.assignment')}}" method="post" enctype="multipart/form-data" id="assignment_form">
                                        @csrf
                                        <input type="hidden" name="lecture_id" value="{{$lecture->id}}">
                                        <div class="mb-3">
                                            <h4 class="form-label mb-3">@if($assignment) @lang('ws.update_assignment') @else @lang('ws.upload_assignment') @endif</h4>
                                            <input class="form-control m-0" type="file" id="file" name="file" required>
                                            <div class="col-12 text-danger" id="file_error"></div>
                                        </div>
                                        <button type="button" class="btn btn-success font-inter font-bold700" id="submit_btn" style="background: #9B3B5A">@lang('ws.submit_file')</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="rtl alert-danger">@lang('ws.assignment_is_not_available')</div>
                        @endif
                    @elseif($lecture->category_id == \App\Models\Lecture::CATEGORY_QUIZ)
                        @if(!$quiz_attempt)
                            <a href="{{route('ws.quiz', ['id' => $lecture->id])}}" class="btn btn-success font-inter font-bold700 mt-3 rtl" style="background: #9B3B5A; display: inline-block; margin: 0 1px 0 auto">@lang('ws.attempt_quiz')</a>
                        @else
                            <div class="row rtl">
                                <div class="col-6 alert alert-warning" role="alert">
                                    @lang('ws.attempted_before')
                                </div>
                                <div class="col-6 alert @if($mark < $questions_count / 2) alert-danger @else alert-success @endif" role="alert">
                                    @lang('ws.your_mark'): {{$mark_text}}
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                <!-- end Left Box -->

                <!-- Right Box -->
                <div class="col-lg-4 right-box-course p-relative">
                    <div class="w-100">
                        <div class="row justify-content-center m-0 w-100 rtl">
                            <div class="row justify-content-between titles-lessons">
                                <div class="col-7 p-0 d-flex align-items-center">
                                    <div class="font-bold700 font-inter">{{$course->getLecturesCount()}} @lang('ws.lectures') ({{$course->hours ?? 0}} @lang('ws.hours'))</div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion container-course" id="accordionExample">
                            @php($i=1)
                            @foreach($course->lectures_groups as $key => $group)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button @if(!$group->lectures->contains($lecture->id)) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                                            <div class="d-flex flex-column">
                                                <div class="font-bold700 font-inter s-small line-height tc-black">{{$group->title}}</div>
                                                <div class="font-bold700 font-inter xs-small tc-gray">{{$group->getLecturesCount()}} @lang('ws.videos')</div>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapse{{$key}}" class="accordion-collapse collapse @if($group->lectures->contains($lecture->id)) show @endif" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        @foreach($group->lectures as $key2 => $group_lecture)
                                            <div class="accordion-body d-flex flex-column p-0 description justify-content-center @if($group_lecture->id == $lecture->id) selected-item @endif">
                                                <div class="d-flex flex-column flex-md-row justify-content-between">
                                                    <div style="padding-right: 10px">
                                                        <div><a class="s-small font-inter font-bold700 tc-gray" href="{{route('ws.course.show', ['course_id' => $course->id, 'lecture_id' => $group_lecture->id])}}">{{$i}}. {{$group_lecture->title}}</a></div>
                                                        @if(!in_array($group_lecture->category_id, [\App\Models\Lecture::CATEGORY_ASSIGNMENT, \App\Models\Lecture::CATEGORY_QUIZ]))
                                                            <div class="xs-small font-inter font-bold700 tc-gray"><i class="fas fa-play-circle"></i>{{$group_lecture->minutes ? $group_lecture->minutes . 'm' : ''}}</div>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex">
                                                        @if($group_lecture->is_user_lecture())
                                                            <div class="complete-text font-inter font-bold700 xs-small" style="padding: 5px">
                                                                @lang('ws.completed')
                                                            </div>
                                                        @endif
                                                        @if($group_lecture->id == $lecture->id && !$user_lecture)
                                                            <form action="{{route('ws.complete_lecture')}}" method="post" enctype="multipart/form-data" id="assignment_form">
                                                                @csrf
                                                                <input type="hidden" name="lecture_id" value="{{$lecture->id}}">
                                                                <button class="btn mark-as-complete font-inter font-bold700 xs-small" style="height: fit-content; padding: 5px">
                                                                    <i class="bi bi-check2"></i>
                                                                    @lang('ws.mark_as_complete')
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if($group_lecture->id == $lecture->id && !in_array($group_lecture->category_id, [\App\Models\Lecture::CATEGORY_ASSIGNMENT, \App\Models\Lecture::CATEGORY_QUIZ]))
                                                            <div class="playing-text font-inter font-bold700 xs-small" style="padding: 5px">
                                                                @lang('ws.playing')
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @php($i++)
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @if(count($course->other_lectures))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button @if(!$course->other_lectures->contains($lecture->id)) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-others" aria-expanded="true" aria-controls="collapse-others">
                                            <div class="d-flex flex-column">
                                                <div class="font-bold700 font-inter s-small line-height tc-black">@lang('ws.other_lectures')</div>
                                                <div class="font-bold700 font-inter xs-small tc-gray">{{count($course->other_lectures)}} @lang('ws.videos')</div>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapse-others" class="accordion-collapse collapse @if($course->other_lectures->contains($lecture->id)) show @endif" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        @foreach($course->other_lectures as $key2 => $group_lecture)
                                            <div class="accordion-body d-flex flex-column p-0 description justify-content-center @if($group_lecture->id == $lecture->id) selected-item @endif">
                                                <div class="d-flex flex-column flex-md-row justify-content-between">
                                                    <div style="padding-right: 10px">
                                                        <div><a class="s-small font-inter font-bold700 tc-gray" href="{{route('ws.course.show', ['course_id' => $course->id, 'lecture_id' => $group_lecture->id])}}">{{$i}}. {{$group_lecture->title}}</a></div>
                                                        @if(!in_array($group_lecture->category_id, [\App\Models\Lecture::CATEGORY_ASSIGNMENT, \App\Models\Lecture::CATEGORY_QUIZ]))
                                                            <div class="xs-small font-inter font-bold700 tc-gray"><i class="fas fa-play-circle"></i>{{$group_lecture->minutes ? $group_lecture->minutes . 'm' : ''}}</div>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex">
                                                        @if($group_lecture->is_user_lecture())
                                                            <div class="complete-text font-inter font-bold700 xs-small" style="padding: 5px">
                                                                @lang('ws.completed')
                                                            </div>
                                                        @endif
                                                        @if($group_lecture->id == $lecture->id && !$user_lecture)
                                                            <form action="{{route('ws.complete_lecture')}}" method="post" enctype="multipart/form-data" id="assignment_form">
                                                                @csrf
                                                                <input type="hidden" name="lecture_id" value="{{$lecture->id}}">
                                                                <button class="btn mark-as-complete font-inter font-bold700 xs-small" style="height: fit-content; padding: 5px">
                                                                    <i class="bi bi-check2"></i>
                                                                    @lang('ws.mark_as_complete')
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if($group_lecture->id == $lecture->id && !in_array($group_lecture->category_id, [\App\Models\Lecture::CATEGORY_ASSIGNMENT, \App\Models\Lecture::CATEGORY_QUIZ]))
                                                            <div class="playing-text font-inter font-bold700 xs-small" style="padding: 5px">
                                                                @lang('ws.playing')
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @php($i++)
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="reviews">
                    <div class="container">
                        <header class="team-header">
                            <h4>@lang('ws.course_reviews')</h4>
                        </header>
                        <div class="reviews-list">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-8">
                                    <div class="reviews-head d-flex justify-content-between align-items-center">
                                        <p>@lang('ws.reviews') (<span id="reviews_count">{{$course->reviews()->count()}}</span>)</p>
                                        <a href="#add-review-modal" data-toggle="modal" class="btn btn-orange">@lang('ws.add_review') <i class="fas fa-plus"></i></a>
                                    </div>
                                    <ul class="list-unstyled have-more mb-0" id="all_reviews">
                                        @include('WS.courses.list_reviews', ['reviews' => $course->reviews()->limit(6)->orderBy('created_at', 'desc')->get()])
                                    </ul>
                                    @if($course->reviews()->count() > 6)
                                        <div class="show-more text-center">
                                            <button type="button" class="btn btn-outline-primary" id="show_more">@lang('ws.show_more')</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="add-review-modal" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <div class="media mt-4 align-items-center">
                                        <div class="media-body">
                                            <h3>@lang('ws.write_review')</h3>
                                        </div>
                                    </div>
                                    <form id="add_review_form">
                                        <div class="cs-form">
                                            <div class="form-group">
                                                <label for="rate">@lang('ws.rate')</label>
                                                <select name="rate" id="rate" class="form-control rating-select" style="max-width: 100%">
                                                    <option value="" disabled selected>--</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                                <span class="text-danger" id="rate_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="comment">@lang('ws.your_comment')</label>
                                                <textarea name="comment" id="comment" class="form-control" placeholder="@lang('ws.your_comment')"></textarea>
                                                <span class="text-danger" id="comment_error"></span>
                                            </div>
                                            <div class="actions">
                                                <button type="button" class="btn mark-as-complete mt-3 px-4 py-3" id="add_review_btn">@lang('ws.send')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{url('/')}}/ws_assets/js/rangeprogress.js"></script>
    <script src="{{url('/')}}/ws_assets/js/progressPercent.js"></script>
    <script>
        $('#assignment_form').validate({
            rules: {
                file: {
                    required: true,
                },
            },
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: true,
            errorPlacement: function (error, element) {
                $(element).addClass("is-invalid");
                $(element).parents('.dropdown.bootstrap-select.form-control').addClass("is-invalid");
                error.appendTo('#' + $(element).attr('id') + '_error');
            },
            success: function (label, element) {
                $(element).removeClass("is-invalid");
                $(element).parents('.dropdown.bootstrap-select.form-control').removeClass("is-invalid");
            }
        });

        $('#submit_btn').click(function(e){
            e.preventDefault();

            if (!$("#assignment_form").valid())
                return false;

            $("#assignment_form").submit();
        });


        let page = {{request('page') ?? 1}};
        $(document).on('click', '#show_more', function () {
            $.ajax({
                url: '{{route('ws.course.more_reviews')}}',
                data: {
                    page: ++page,
                    id: '{{$course->id ?? ''}}',
                    _token: '{{csrf_token()}}'
                },
                type: "POST",
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
                        $('#all_reviews').append(data.page);
                        if (data.last_page) {
                            $('#show_more').fadeOut(300);
                            $('.reviews-list .have-more li:last-child .review-item').css({
                                'opacity': 1,
                                'background': '#fff'
                            });
                        }
                    } else {
                        showAlertMessage('error', '@lang('constants.unknown_error')');
                    }
                    unblockPage();
                },
            });
        });

        $('#add_review_form').validate({
            rules: {
                rate: {
                    required: true,
                },
                comment: {
                    required: true,
                },
            },
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: true,
            errorPlacement: function (error, element) {
                $(element).addClass("is-invalid");
                error.appendTo('#' + $(element).attr('id') + '_error');
            },
            success: function (label, element) {
                $(element).removeClass("is-invalid");
            },
        });

        $(document).on('click', '#add_review_btn', function () {
            if (!$('#add_review_form').valid())
                return false;
            $.ajax({
                url : '{{route('ws.course.add_review')}}',
                data : {
                    _token: '{{csrf_token()}}',
                    rate: $('#rate').val(),
                    comment: $('#comment').val(),
                    id: {{$course->id}},
                },
                type: "POST",
                beforeSend(){
                    block('#add-review-modal', {
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: '@lang('constants.please_wait') ...'
                    });
                },
                success:function(data) {
                    if (data.success) {
                        showAlertMessage('success', data.message);
                        unblock('#add-review-modal');
                        $("#add-review-modal .close").click();
                        $('#all_reviews').prepend(data.page);
                        $('#reviews_count').html((parseInt($('#reviews_count').text())+1));
                        $('#rate').val(0).trigger('change');
                        $('#comment').val('');
                    } else {
                        for (let i = 0; i < data.errors.length; i++) {
                            showAlertMessage('error', data.errors[i]);
                        }
                        unblock('#add-review-modal');
                    }
                },
            });
        });

        $(document).on('click', '.delete_review', function () {
            let $this = $(this);
            $.ajax({
                url: '{{route('ws.course.delete_review')}}',
                data: {
                    id: $(this).data('id'),
                    _token: '{{csrf_token()}}'
                },
                type: "POST",
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
                        showAlertMessage('success', data.message);
                        $this.parents('li').remove();
                        $('#reviews_count').html((parseInt($('#reviews_count').text())-1));
                    } else {
                        showAlertMessage('error', '@lang('constants.unknown_error')');
                    }
                    unblockPage();
                },
            });
        })
    </script>
@endsection
