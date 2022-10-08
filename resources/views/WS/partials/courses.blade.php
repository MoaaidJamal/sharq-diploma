@foreach($courses as $course)
    @php($score = $course->getUserScore())
    <div class="diplomaProgramBox">
        <div class="diplomIconCont">
            <div class="diplomaIcon ">
                <img src="{{$course->image}}" style="border-radius: 50%" alt="">
            </div>
        </div>
        <div class="diplomaProgramDetails">
            <div class="diplomaProgramTitle">
                <h6>
                    @if($course->is_available)
                        <a href="{{route('ws.course.show', ['course_id' => $course->id])}}" style="color:#000; text-decoration:none;">
                            {{$course->title}}
                        </a>
                    @else
                        {{$course->title}}
                    @endif
                </h6>
                <span style="width: fit-content">{{$course->phase->title}}</span>
            </div>
            <p>
                {!! $course->description !!}
            </p>
            <ul class="DiplomaListDetails">
                <li>
                    {{$course->available_lectures ? $course->available_lectures->count() : 0}} @lang('ws.lectures')
                </li>
                <li>
                    {{$course->hours}} @lang('ws.hours')
                </li>
            </ul>
        </div>
        <div class="diplomaChart">
            @if(!$course->is_available)
                <div class="diplomaChart text-center">
                    <div class="lockedCourse">
                        <div class="lockedCourseImg">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    <h6>@lang('ws.locked')</h6>
                </div>
            @elseif($score > 0)
                <div class="@if($score == 100) success @elseif($score < 100) InProgress @endif chart" data-percent="{{$score/100}}"><span>{{$score/100}}%</span></div>
                <h6>@if($score == 100) @lang('ws.completed') @elseif($score > 0 && $score < 100) @lang('ws.in_progress') @endif</h6>
            @endif
        </div>
    </div>
@endforeach
