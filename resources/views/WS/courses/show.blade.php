@extends('WS.layouts.main')

@section('title') @lang('ws.module') - {{$course->title}} @endsection
@section('modules_active') active @endsection

@section('style')
    <style>
        .textContainer {
            overflow-y: scroll;
        }

        .rating-stars ul {
            list-style-type:none;
            padding:0;

            -moz-user-select:none;
            -webkit-user-select:none;
        }
        .rating-stars ul > li.star {
            display:inline-block;

        }

        .rating-stars ul > li.star > i.fa {
            font-size:2.5em; /* Change the size of the stars */
            color:#ccc; /* Color on idle state */
        }

        .rating-stars ul > li.star.hover > i.fa {
            color:#FFCC36;
        }

        .rating-stars ul > li.star.selected > i.fa {
            color:#FF912C;
        }

    </style>
@endsection

@section('body')
    <section class="course-Details clearfix">
        <div class="CurriculumBox sideCurriclum">
            <div class="curriculumCon">
                <h4>@lang('ws.curriculum')</h4>
                @foreach($course->lectures_groups as $group)
                    <ul class="CurriculumList">
                        <li>
                            <a class="CurriculumLink" href="javaScript:;" role="button" aria-expanded="false"
                               aria-controls="">
                                {{$group->title}}
                                <span class="lni @if($group->lectures->contains($lecture->id)) lni-chevron-up @else lni-chevron-down @endif"></span>
                            </a>
                            <ul class="innerCurriculumList" @if($group->lectures->contains($lecture->id)) style="display: block" @endif>
                                @foreach($group->lectures as $group_lecture)
                                    @include('WS.courses.curriculum_lecture', ['group_lecture' => $group_lecture])
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                @endforeach
                <ul class="CurriculumList">
                    <li>
                        <a class="CurriculumLink" href="javaScript:;" role="button" aria-expanded="false"
                           aria-controls="">
                            @lang('ws.other_lectures')
                            <span class="lni @if($course->other_lectures->contains($lecture->id)) lni-chevron-up @else lni-chevron-down @endif"></span>
                        </a>
                        <ul class="innerCurriculumList" @if($course->other_lectures->contains($lecture->id)) style="display: block" @endif>
                            @foreach($course->other_lectures as $group_lecture)
                                @include('WS.courses.curriculum_lecture', ['group_lecture' => $group_lecture])
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="courseVideoAndDetails">
            <div class="col-md-12">
                <div class="videoSec clearfix">
                    @php($score = $course->getUserScore())
                    <div class="videoTitle clearfix @if(!in_array($lecture->file_type, [1,2]) || in_array($lecture->category_id, [\App\Models\Lecture::CATEGORY_QUIZ, \App\Models\Lecture::CATEGORY_ZOOM])) text-videoTitle @endif">
                        <div class="diplomaChart">
                            <div class="videoChart chart" data-percent="{{$score}}">
                                <span>{{$score}}%</span>
                            </div>
                        </div>
                        <div class="videoTitleDetails">
                            <h6>{{$course->title}}</h6>
                            <span style="font-size:13px;font-weight: 500;">{{$course->getLecturesCount()}} @lang('ws.lectures') ({{$course->hours ?? 0}} @lang('ws.hours'))</span>
                        </div>
                        <div class="progress headerProgressBar">
                            <div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0"
                                 aria-valuemax="100" style="width:{{$score}}%">
                                <span class="sr-only">{{$score}}% @lang('ws.completed')</span>
                            </div>
                        </div>
                    </div>
                    @if(!in_array($lecture->category_id, [\App\Models\Lecture::CATEGORY_QUIZ, \App\Models\Lecture::CATEGORY_ZOOM, \App\Models\Lecture::CATEGORY_ASSIGNMENT]))
                        @if($lecture->embedded_code)
                            <div>
                                {!! $lecture->embedded_code !!}
                            </div>
                        @else
                            @if($lecture->file_type == 1)
                                <div id="videoSecCont">
                                    <iframe width="100%" height="500px" src="https://www.youtube.com/embed/{{$lecture->video_id}}"></iframe>
                                </div>
                            @elseif($lecture->file_type == 2)
                                <div id="videoSecCont">
                                    <iframe width="100%" height="500px" src="https://player.vimeo.com/video/{{$lecture->video_id}}"></iframe>
                                </div>
                            @elseif(in_array($lecture->file_type, [3,4]))
                                <div class="textContainer LessondownloadFileCont text-center">
                                    <i class="downloadLessonIcon"><img src="{{url('/')}}/ws_assets/images/downloadingLesson.svg" alt=""></i>
                                    <div class="sectionTitle text-center">
                                        <h5>PDF @lang('ws.file')</h5>
                                    </div>
                                    <a href="{{$lecture->file}}" target="_blank" class="btn CertificateDownloadBtn commonBtn"> <span>@lang('ws.download')</span></a>
                                </div>
                            @elseif($lecture->file_type == 5)
                                <div class="textContainer scrollableText">
                                    <p>
                                        {!! $lecture->content !!}
                                    </p>
                                </div>
                            @endif
                        @endif
                    @endif
                    @if($lecture->category_id == \App\Models\Lecture::CATEGORY_ZOOM)
                        <div class="textContainer  zoomCont text-center">
                            <i class="downloadLessonIcon"><img src="{{url('/')}}/ws_assets/images/meetingZoom.svg" alt=""></i>
                            <div class="sectionTitle text-center">
                                <h5>@lang('ws.zoom_meeting')</h5>
                                <p>@lang('ws.this_live_lecture'): {{\Carbon\Carbon::parse($lecture->start_date)->toDateTimeString()}}</p>
                            </div>
                            <a href="{{$lecture->join_url}}" target="_blank" class="zoomLink">{{$lecture->join_url}}</a>
                        </div>
                    @endif
                    @if($lecture->category_id == \App\Models\Lecture::CATEGORY_QUIZ)
                        <div class="textContainer  zoomCont text-center">
                            <i class="downloadLessonIcon">
                                <img src="{{url('/')}}/ws_assets/images/meetingZoom.svg" alt="">
                            </i>
                            <div class="sectionTitle text-center">
                                <h5>@lang('ws.quiz')</h5>
                                @if($quiz_attempt)
                                    <p>@lang('ws.attempted_before')</p>
                                @endif
                            </div>
                            @if(!$quiz_attempt)
                                <a href="{{route('ws.quiz', ['id' => $lecture->id])}}" class="zoomLink" style="background: #9B3B5A; display: inline-block; margin: 0 1px 0 auto">@lang('ws.attempt_quiz')</a>
                            @else
                                <div class="alert @if($mark < $questions_count / 2) alert-danger @else alert-success @endif d-inline-block m-auto" role="alert">
                                    @lang('ws.your_mark'): {{$mark_text}}
                                </div>
                            @endif
                        </div>
                    @endif
                    @if($lecture->category_id == \App\Models\Lecture::CATEGORY_ASSIGNMENT && $lecture->assignment)
                        <div class="textContainer LessondownloadFileCont homeworkCont text-center">
                            <i class="downloadLessonIcon"><img src="{{url('/')}}/ws_assets/images/homework1.svg" alt=""></i>
                            <div class="sectionTitle text-center">
                                <h5>@lang('ws.assignment')</h5>
                            </div>
                            <div>
                                {!! $lecture->assignment !!}
                            </div>

                            @if($assignment)
                                <div class="row mb-3 d-flex justify-content-center border-top pt-3">
                                    <h6 style="margin: 0;">@lang('ws.your_submitted_file'): &nbsp  <a href="{{$assignment->file}}" class="commonBtn uploadHomeworkBtn btn" download="{{$assignment->file_name}}" style="padding: 10px;">@lang('ws.your_file')</a></h6>
                                </div>
                            @endif
                            @if(\Carbon\Carbon::parse($lecture->start_date)->lt(now()) && \Carbon\Carbon::parse($lecture->end_date)->gt(now()))
                                <form action="{{route('ws.assignment')}}" method="post" enctype="multipart/form-data" id="assignment_form" class="border-top pt-3">
                                    @csrf
                                    <input type="hidden" name="lecture_id" value="{{$lecture->id}}">
                                    <div class="mb-3">
                                        <h5 class="form-label mb-3">@if($assignment) @lang('ws.update_assignment') @else @lang('ws.upload_assignment') @endif</h5>
                                        <input class="m-0 fileUpload" type="file" id="file" name="file" required style="margin: auto">
                                        <div class="col-12 text-danger" id="file_error"></div>
                                    </div>
                                    <button type="button" class="commonBtn uploadHomeworkBtn btn" id="submit_btn" style="padding: 10px;">@lang('ws.submit_file')</button>
                                </form>
                            @else
                                <div class="text-danger">@lang('ws.assignment_is_not_available')</div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div class="course-DetailsCont" id="coursesTabContent">
                <div class="container">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="aboutCourse" id="aboutCourse">
                                @if($lecture->description)
                                    <h6 class="aboutCourseTitle">
                                        @lang('ws.about') @if($lecture->category_id == \App\Models\Lecture::CATEGORY_QUIZ) @lang('ws.quiz') @elseif($lecture->category_id == \App\Models\Lecture::CATEGORY_ASSIGNMENT) @lang('ws.assignment') @else @lang('ws.lecture') @endif
                                    </h6>
                                    <p class="aboutCoursePar">
                                        {!! $lecture->description !!}
                                    </p>
                                @endif
                            </div>
                            @if($course->user)
                                <div class="lectureDetails" id="lectureDetails">
                                    <h6 class="aboutCourseTitle">
                                        @lang('ws.lecturer')
                                    </h6>
                                    <div class="lectureDetailsBox clearfix">
                                        <div class="lectureImg"><img src="{{$course->user->full_path_image}}" alt=""></div>
                                        <div class="lectureDesc">
                                            <h6 class="aboutCourseTitle">{{$course->user->name}}</h6>
                                            <p class="aboutCoursePar">
                                                {{$course->user->bio}}
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            <div class="Learnerreviews" id="Reviews">
                                <h6 class="aboutCourseTitle">@lang('ws.course_reviews')</h6>
                                <div class="Totlereviews clearfix" id="summery">
                                    @include('WS.courses.reviews_summery', ['course' => $course])
                                </div>
                                <div id="all_reviews">
                                    @include('WS.courses.list_reviews', ['reviews' => $course->reviews()->limit(6)->orderBy('created_at', 'desc')->get()])
                                </div>
                                @if($course->reviews()->count() > 6)
                                    <div class="btnContainer">
                                        <a href="javascript:;" class="btn enrollBtn commonBtn" id="show_more">
                                            <span>
                                                @lang('ws.show_more')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15.494" height="8.426"
                                                            viewBox="0 0 15.494 8.426">
                                                    <g id="Arrow_-_Right" data-name="Arrow - Right"
                                                       transform="translate(0.919 0.919)">
                                                        <path id="Stroke_3" data-name="Stroke 3"
                                                              d="M13.655,0,6.828,6.857,0,0" transform="translate(0)"
                                                              fill="none" stroke="#761c33" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-miterlimit="10"
                                                              stroke-width="1.3" />
                                                    </g>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                <div class="leaveReview">
                                    <h6 class="aboutCourseTitle">@lang('ws.leave_review')</h6>
                                    <div class='rating-stars text-center'>
                                        <ul id='stars'>
                                            <li class='star' title='Poor' data-value='1'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Fair' data-value='2'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Good' data-value='3'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Excellent' data-value='4'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='WOW!!!' data-value='5'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                    <span class="text-danger" id="rate_error"></span>
                                    <form class="leavReviewForm" id="add_review_form">
                                        <input type="hidden" name="rate" id="rate" value="">
                                        <textarea name="comment" id="comment" class="leaveReviewComment"
                                                  placeholder="Write comment here..."></textarea>
                                        <span class="text-danger" id="comment_error"></span>
                                        <button class="btn commonBtn postComment" id="add_review_btn"><span>@lang('ws.submit_review')</span></button>
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
                        $(".learnerReviewsReadOnly").starRating({
                            starSize: 16,
                            activeColor: '#FFD93F',
                            hoverColor: '#FFD93F',
                            ratedColor: '#FFD93F',
                            emptyColor: 'transparent',
                            starShape: 'straight',
                            strokeColor: '#FFD93F',
                            strokeWidth: 9,
                            ratedColors: '#FFD93F',
                            useGradient: false,
                            readOnly: true,
                            rtl:true,
                            callback: function (currentRating, $el) {
                                // make a server call here
                            }
                        });
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

        $(document).on('click', '#add_review_btn', function (e) {
            e.preventDefault();
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
                    blockPage({
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: '@lang('constants.please_wait') ...'
                    });
                },
                success:function(data) {
                    if (data.success) {
                        showAlertMessage('success', data.message);
                        $('#all_reviews').prepend(data.page);
                        $('#summery').html(data.summery);
                        $('li.star').removeClass('selected');
                        $('#rate').val('');
                        $('#comment').val('');
                        $(".learnerReviewsReadOnly").starRating({
                            starSize: 16,
                            activeColor: '#FFD93F',
                            hoverColor: '#FFD93F',
                            ratedColor: '#FFD93F',
                            emptyColor: 'transparent',
                            starShape: 'straight',
                            strokeColor: '#FFD93F',
                            strokeWidth: 9,
                            ratedColors: '#FFD93F',
                            useGradient: false,
                            readOnly: true,
                            rtl:true,
                            callback: function (currentRating, $el) {
                                // make a server call here
                            }
                        });
                    } else {
                        for (let i = 0; i < data.errors.length; i++) {
                            showAlertMessage('error', data.errors[i]);
                        }
                    }
                    unblockPage();
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
                        $('#summery').html(data.summery);
                        $this.parents('.learnerReviewBox').remove();
                        $(".learnerReviewsReadOnly").starRating({
                            starSize: 16,
                            activeColor: '#FFD93F',
                            hoverColor: '#FFD93F',
                            ratedColor: '#FFD93F',
                            emptyColor: 'transparent',
                            starShape: 'straight',
                            strokeColor: '#FFD93F',
                            strokeWidth: 9,
                            ratedColors: '#FFD93F',
                            useGradient: false,
                            readOnly: true,
                            rtl:true,
                            callback: function (currentRating, $el) {
                                // make a server call here
                            }
                        });
                    } else {
                        showAlertMessage('error', '@lang('constants.unknown_error')');
                    }
                    unblockPage();
                },
            });
        })

        $('.checkmarkCont').click(function () {
            if ($(this).parents('form.complete_lecture')) {
                $(this).parent().submit();
            }
        })



        $(document).ready(function(){
            $('#stars li').on('mouseover', function(){
                var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
                $(this).parent().children('li.star').each(function(e){
                    if (e < onStar) {
                        $(this).addClass('hover');
                    }
                    else {
                        $(this).removeClass('hover');
                    }
                });
            }).on('mouseout', function(){
                $(this).parent().children('li.star').each(function(e){
                    $(this).removeClass('hover');
                });
            }).on('click', function(){
                var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                var stars = $(this).parent().children('li.star');

                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');
                }

                var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                $('#rate').val(ratingValue);
            });
        });
    </script>
@endsection
