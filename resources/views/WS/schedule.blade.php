@extends('WS.layouts.main')

@section('title') @lang('ws.schedule') @endsection
@section('schedule_active') active @endsection

@section('style')
    <link href="{{url('/')}}/ws_assets/css/fullcalendar.css" rel="stylesheet">
    <style>
        a.fc-day-grid-event {
            text-decoration: none !important;
        }

        .fc-time, .fc-title, .fc-event-container {
            color: #9b3b5a !important;
        }

        .tooltip-arrow {
            display: none !important;
        }

        .fc-day-number {
            margin: 5px;
            display: block;
            font-weight: 500;
        }

        .tooltip.show {
            opacity: 1;
        }

        .fc-today {
            background: #ffeff5;
        }

        .fc-other-month {
            background: #f4f4f4;
        }

        .tooltip-inner {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
            box-shadow: 0 10px 54px -15px rgba(0, 0, 0, 0.15);
            position: absolute;
            background: #ffffff !important;
            border-radius: 8px !important;
            color: #232323 !important;
            width: 426px !important;
            max-width: 426px !important;
            height: fit-content !important;
            left: -91px;
            top: 0;
        }

        .tooltip-inner div {
            text-align: left;
            color: #000;
            flex: none;
            order: 1;
            font-size: 14px;
            font-weight: bolder;
            padding: 5px 10px;
            margin-bottom: 10px;
        }

        .tooltip-inner div:first-child {
            background: rgba(155, 59, 90, 0.07);
            text-align: left;
            color: #9B3B5A;
            flex: none;
            order: 0;
            flex-grow: 0;
            font-size: 16px;
            font-weight: bolder;
            padding: 5px 10px;
            margin-bottom: 10px;
        }

        .tooltip-inner div:last-child {
            background: #DADADA;
            text-align: center;
            color: #000;
            flex: none;
            order: 3;
            flex-grow: 0;
            font-size: 12px;
            padding: 5px 10px;
            margin-left: auto;
            margin-bottom: 0;
        }

        .btn-link {
            background: #9B3B5A;
            border-radius: 3px;
            padding: 10px 12px;
            color: #fff;
            text-decoration: none;
            display: block;
            margin-right: 6px;
            width: 200px;
            text-align: center;
            margin-left: auto;
        }

        .btn-link:hover {
            color: #fff;
        }
    </style>
@endsection

@section('body')

    <section class="d-flex fc" style="flex-direction: column; align-items: start;" data-aos="fade-down">
        <h2 style="font-family: Inter;font-style: normal;font-weight: bold;font-size: 22px;line-height: 21px;color: #1B1B1B;margin-bottom: 7px; margin-top: 20px">
            @lang('ws.schedule')
        </h2>
    </section>
    <div class="mb-5" id='calendar' data-aos="fade-down"></div>

@endsection
@section('js')
    <script src="{{url('/')}}/ws_assets/plugins/fullcalendar/main.min.js"></script>
    <script src="{{url('/')}}/ws_assets/plugins/fullcalendar/daygrid.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var calendarEl = document.getElementById("calendar");
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ["dayGrid"],
                defaultView: "dayGridMonth",
                eventRender: function(info) {
                    $(info.el).tooltip({
                        title: info.event.extendedProps.description,
                        html: true,
                        placement: "bottom",
                        trigger: "hover",
                        container: "body",
                    });
                },
                events: [
                    @foreach($courses as $course)
                        {
                            title: "{{$course->title}}",
                            description: "<div>{{$course->title}}</div><div>{{\Illuminate\Support\Str::limit(cleanText($course->description), 200)}}</div><div>{{\Carbon\Carbon::parse($course->start_date)->format('Y-m-d')}} - {{\Carbon\Carbon::parse($course->end_date)->format('Y-m-d')}}</div>",
                            start: "{{\Carbon\Carbon::parse($course->start_date)->toDateTimeString()}}",
                            end: "{{\Carbon\Carbon::parse($course->end_date)->toDateTimeString()}}",
                            url: '{{route('ws.course.show', ['course_id' => $course->id])}}'
                        },
                    @endforeach
                ],
                eventClick: function(event) {
                    if (event.url) {
                        window.open(event.url, "_blank");
                        return false;
                    }
                }
            });
            calendar.render();
        });
    </script>
@endsection
