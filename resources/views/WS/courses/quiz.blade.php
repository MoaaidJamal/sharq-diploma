@extends('WS.layouts.main')

@section('title') @lang('ws.quiz') - {{$lecture->title}} @endsection
@section('modules_active') active @endsection

@section('style')
    <link href="{{url('/')}}/ws_assets/css/stepper.css" rel="stylesheet" />
    <link href="{{url('/')}}/ws_assets/css/quiz.css" rel="stylesheet" />
    <link href="{{url('/')}}/ws_assets/css/Lessonassignment.css" rel="stylesheet" />
    <style>
        header {
            margin-bottom: 0 !important;
        }

        [type=submit] {
            height: 40px;
            width: auto;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            float: right;
        }
    </style>
@endsection

@section('body')


    <div class="container-fluid rtl">
        <div class="d-flex justify-content-center mt-0">
            <div class="col-10 col-lg-7 text-center p-0 mt-3 ">
                <div class="px-0 pb-0 mb-3">
                    <div class="s-small tc-gray-2 font-inter font-bold600">@lang('ws.lecture_quiz')</div>
                    <div class="font-inter font-bold700 mb-3">{{$lecture->title}}</div>
                </div>
                <ul id="progressbar">
                    @foreach($questions as $key => $question)
                        <li @if($key == 0) class="active" @endif id="q{{$key}}">
                            <span>{{$key+1}}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid rtl" style="background-color: #f7f5fa !important;">
        <div class="d-flex justify-content-center mt-0 py-5 height">
            <div class="col-10 col-lg-7 text-center p-0 mt-3 mb-2">
                <div class="row">
                    <div class="mx-0">
                        <form action="{{route('ws.quiz_attempt')}}" method="POST" id="msform">
                            @csrf
                            <input type="hidden" name="lecture_id" value="{{$lecture->id}}">
                            @foreach($questions as $key => $question)
                                <fieldset>
                                    <div>
                                        <div class="d-flex flex-column mb-4">
                                            {!! $question->question !!}
                                            @if($question->answer1)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="questions[{{$question->id}}]" id="q{{$key+1}}-1" value="1">
                                                    <label class="form-check-label font-inter font-bold700 s-small" for="q{{$key+1}}-1">
                                                        {!! $question->answer1 !!}
                                                    </label>
                                                </div>
                                            @endif
                                            @if($question->answer2)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="questions[{{$question->id}}]" id="q{{$key+1}}-2" value="2">
                                                    <label class="form-check-label font-inter font-bold700 s-small" for="q{{$key+1}}-2">
                                                        {!! $question->answer2 !!}
                                                    </label>
                                                </div>
                                            @endif
                                            @if($question->answer3)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="questions[{{$question->id}}]" id="q{{$key+1}}-3" value="3">
                                                    <label class="form-check-label font-inter font-bold700 s-small" for="q{{$key+1}}-3">
                                                        {!! $question->answer3 !!}
                                                    </label>
                                                </div>
                                            @endif
                                            @if($question->answer4)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="questions[{{$question->id}}]" id="q{{$key+1}}-4" value="4">
                                                    <label class="form-check-label font-inter font-bold700 s-small" for="q{{$key+1}}-4">
                                                        {!! $question->answer4 !!}
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($loop->last)
                                        <div class="d-flex justify-content-between">
                                            <input type="button" name="previous" class="btn previous action-button next-btn" value="Previous Questions" />
                                            <input type="submit" name="submit" class="btn action-button btn-success" value="Submit Your Attempt" />
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-between" style="flex-direction: row-reverse;">
                                            @if(!$loop->first)
                                                <input type="button" name="previous" class="btn previous action-button next-btn" value="Previous Questions" />
                                            @endif
                                            <input type="button" name="next" class="btn next action-button next-btn" value="Next Questions" />
                                        </div>
                                    @endif
                                </fieldset>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{url('/')}}/ws_assets/js/stepper.js"></script>
@endsection
