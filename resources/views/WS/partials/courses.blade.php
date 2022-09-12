@foreach($courses as $course)
    <div class="col-12 col-sm-6 col-lg-4 mb-4">
        <div class="card-custom">
            <div class="container-text-prog d-flex justify-content-between w-100">
                <div class="div-progress">
                    <div class="phase circle @if($course->getUserScore() == 100) p-completed @elseif($course->getUserScore() > 0 && $course->getUserScore() < 100) p-in-progress @endif" data-prog="{{$course->getUserScore()/100}}">
                        <div class="@if(locale() == 'ar') img-progress-rtl @else img-progress @endif">
                            <img src="{{$course->image}}" style="width: 90%; height: 90%; margin: auto"/>
                        </div>
                    </div>
                </div>
                @if($course->is_available)
                    <div>
                        <a href="{{route('ws.course.show', ['course_id' => $course->id])}}" class="btn btn-link font-inter font-bold700 s-small">@lang('ws.view_module')</a>
                    </div>
                @endif
            </div>
            <div class="d-flex flex-column w-100">
                <div class="d-flex my-3">
                    <div class="s-small font-bold700 phase-text">@lang('ws.module') {{$course->order}}</div>
                    @if($course->getUserScore() == 100)
                        <div class="s-small font-bold700 complete-text">@lang('ws.completed')</div>
                    @endif
                    @if($course->getUserScore() > 0 && $course->getUserScore() < 100)
                        <div class="s-small font-bold700 in-progress ">@lang('ws.in_progress')</div>
                    @endif
                </div>
                <div class="box">
                    <h3 class="font-inter font-bold700">
                        @if($course->is_available)
                            <a href="{{route('ws.course.show', ['course_id' => $course->id])}}" style="color:#000; text-decoration:none;">
                                {{$course->title}}
                            </a>
                        @else
                            {{$course->title}}
                        @endif
                    </h3>
                    <div class="s-small tc-gray">
                        {!! $course->description !!}
                    </div>
                </div>
            </div>
            <div class="mb-3 h-30">
                <span class="font-inter font-bold700 xs-small tc-gray">{{$course->available_lectures ? $course->available_lectures->count() : 0}} @lang('ws.lectures')</span>
                <span class="font-inter font-bold700 xs-small tc-gray"><i class="bi bi-dot"></i>{{$course->hours}} @lang('ws.hours')</span>
            </div>
        </div>
    </div>
@endforeach
