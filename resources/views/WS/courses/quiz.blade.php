@extends('WS.layouts.main')

@section('title') @lang('ws.quiz') - {{$lecture->title}} @endsection
@section('modules_active') active @endsection

@section('style')
    <style>
        .action-button {
            border: none;
            padding: 0 30px;
        }
    </style>
@endsection

@section('body')

    <section class="coursesHeader">
        <div class="container">
            <div class="row ">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item "><a href="javascript:;">@lang('ws.lecture_quiz')</a> </li>
                            <li class="breadcrumb-item active" aria-current="page">{{$lecture->title}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-12">
                    <h5>{{$lecture->course->title}}
                        <span> {{$lecture->course->phase->title}} </span>
                    </h5>
                    <div class="progress headerProgressBar">
                        <div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0"
                             aria-valuemax="100" style="width:{{$lecture->course->getUserScore()}}%">
                            <span class="sr-only">{{$lecture->course->getUserScore()}}% @lang('ws.completed')</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ExamContainer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ExamCont">
                        <form action="{{route('ws.quiz_attempt')}}" class="examForm" method="POST" id="msform">
                            @csrf
                            <input type="hidden" name="lecture_id" value="{{$lecture->id}}">
                            @foreach($questions->chunk(4) as $chunk)
                                <fieldset @if($loop->first) style="opacity: 1;" @else style="display: none; position: relative; opacity: 0;" @endif>
                                    @foreach($chunk as $key => $question)
                                        <div class="QuestionBox">
                                            <h4>
                                                {!! $question->question !!}
                                            </h4>
                                            <div class="AnswersBox">
                                                @if($question->answer1)
                                                    <label class="radioBtnContainer">
                                                        {!! $question->answer1 !!}
                                                        <input type="radio" class="radioInput" name="questions[{{$question->id}}]" id="q{{$key+1}}-1" value="1">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                @endif
                                                @if($question->answer2)
                                                    <label class="radioBtnContainer">
                                                        {!! $question->answer2 !!}
                                                        <input type="radio" class="radioInput" name="questions[{{$question->id}}]" id="q{{$key+1}}-1" value="2">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                @endif
                                                @if($question->answer3)
                                                    <label class="radioBtnContainer">
                                                        {!! $question->answer3 !!}
                                                        <input type="radio" class="radioInput" name="questions[{{$question->id}}]" id="q{{$key+1}}-1" value="3">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                @endif
                                                @if($question->answer4)
                                                    <label class="radioBtnContainer">
                                                        {!! $question->answer4 !!}
                                                        <input type="radio" class="radioInput" name="questions[{{$question->id}}]" id="q{{$key+1}}-1" value="4">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($loop->last)
                                        <div class="d-flex justify-content-between">
                                            <input type="button" name="previous" class="action-button commonBtn sumbitExamBtn previous next-btn" value="Previous Questions" />
                                            <input type="submit" name="submit" class="commonBtn btn action-button btn-success" value="Submit Your Attempt" />
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-between" style="flex-direction: row-reverse;">
                                            @if(!$loop->first)
                                                <input type="button" name="previous" class="action-button commonBtn sumbitExamBtn previous next-btn" value="Previous Questions" />
                                            @endif
                                            <input type="button" name="next" class="action-button commonBtn sumbitExamBtn next next-btn" value="Next Questions" />
                                        </div>
                                    @endif
                                </fieldset>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
    <script src="{{url('/')}}/ws_assets/js/stepper.js"></script>
@endsection
