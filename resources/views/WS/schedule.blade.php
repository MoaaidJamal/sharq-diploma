@extends('WS.layouts.main')

@section('title')
    {{$settings->schedule_menu_title}}
@endsection
@section('schedule_active')
    active
@endsection

@section('style')
    <link href="{{url('/')}}/ws_assets/css/fullcalender.css" rel="stylesheet">
@endsection

@section('body')
    <section class="coursesHeader">
        <div class="container">
            <div class="row ">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">{{$settings->home_menu_title}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$settings->schedule_menu_title}}</li>
                        </ol>
                    </nav>

                </div>
                <div class="col-md-8">
                    <h5>
                        {{$settings->schedule_menu_title}}
                    </h5>
                </div>
            </div>
        </div>
    </section>

    <section class="ScheduleBody">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="calenderCont">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
    <script type="text/javascript" src="{{url('/')}}/ws_assets/js/fullcalender.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'title,prev,next',
                    //  center: '',
                    right: ''
                },
                navLinks: true, // can click day/week names to navigate views
                businessHours: true, // display business hours
                editable: true,
                selectable: true,
                eventBackgroundColor: "rgba(118, 28, 51, .08)",
                events: [
                        @foreach($courses as $course)
                    {
                        title: "{{$course->title}}",
                        instructor: "{{$course->user->name}}",
                        instructor_image: "{{$course->user->full_path_image}}",
                        description: "{{\Illuminate\Support\Str::limit(cleanText($course->description), 200)}}",
                        start_from: "{{\Carbon\Carbon::parse($course->start_date)->format('H:i a')}}",
                        start: "{{\Carbon\Carbon::parse($course->start_date)->toDateTimeString()}}",
                        end: "{{\Carbon\Carbon::parse($course->end_date)->toDateTimeString()}}",
                        url: '{{route('ws.course.show', ['course_id' => $course->id])}}'
                    },
                    @endforeach
                ],
                eventMouseEnter: function (info) {
                    $('.fc-description').remove();
                    var element = $(info.el);
                    element.append(`<a href="${info.event.url}">
                                        <div class="fc-description">
                                            <div class="triangle-up">
                                                <div class="inner-triangle"></div>
                                            </div>
                                            <div class="eventDescHeader">
                                                <div class="eventDescImg">
                                                    <img src="${info.event.extendedProps.instructor_image}" alt="">
                                                </div>
                                                <div class="eventDescName">
                                                    <div class="leftEvent">
                                                        <h4>${info.event.extendedProps.instructor}</h4>
                                                        <span>
                                                            ${info.event.extendedProps.start_from}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="EventDescription">
                                                <p> ${info.event.title}</p>
                                            </div>
                                        </div>
                                    </a>`);
                },
                eventMouseLeave: function () {
                    $('.fc-description').remove();
                }

            });
            calendar.render();
        });
    </script>
@endsection
