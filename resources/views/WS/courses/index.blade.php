@extends('WS.layouts.main')

@section('title') {{$settings->learning_paths_menu_title}} @endsection
@section('module_active') active @endsection

@section('body')
    <section class="coursesHeader">
        <div class="container">
            <div class="row ">
                <div class="col-md-8">
                    <nav aria-label="bre adcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">{{$settings->home_menu_title}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$settings->learning_paths_menu_title}}</li>
                        </ol>
                    </nav>
                    <h5>
                        {{$settings->learning_paths_menu_title}}
                    </h5>
                    <p>
                        {{$settings->learning_paths_description}}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="diplomaProgram">
        <div class="container">
            @if(count($courses))
                <div class="row">
                    @include('WS.partials.courses', ['courses' => $courses])
                </div>
            @else
                <div class="alert alert-danger">@lang('ws.no_courses_to_show')</div>
            @endif
        </div>
    </section>
@endsection
