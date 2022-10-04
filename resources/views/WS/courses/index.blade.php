@extends('WS.layouts.main')

@section('title') @lang('ws.modules') @endsection
@section('module_active') active @endsection

@section('body')
    <section class="learning-path" data-aos="fade-down">
        <div class="container rtl">
            @if(count($courses))
                <h2 class="font-inter px-0 d-flex ">{{$settings->learning_paths_title}}</h2>
                <div class="font-inter " style="margin-bottom: 15px;">{{$settings->learning_paths_description}}</div>
                <div class="row">
                    @include('WS.partials.courses', ['courses' => $courses])
                </div>
            @else
                <div class="alert alert-danger">@lang('ws.no_courses_to_show')</div>
            @endif
        </div>
    </section>
@endsection
