@extends('WS.layouts.main')

@section('title') {{$settings->home_menu_title}} @endsection
@section('mentors_active') active @endsection

@section('body')
    <section class="coursesHeader">
        <div class="container">
            <div class="row ">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">{{$settings->home_menu_title}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$settings->popular_mentors_title}}</li>
                        </ol>
                    </nav>
                    <h5>
                        {{$settings->popular_mentors_title}}
                    </h5>
                    <p>
                        {{$settings->popular_mentors_description}}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="Instructors instructorPageBody">
        <div class="container">
            <div class="row">
                @if(count($mentors))
                    @foreach($mentors as $mentor)
                        <div class="col-md-3 col-6">
                            @include('WS.users.user_card', ['user' => $mentor])
                        </div>
                    @endforeach
                @else
                    <section class="learning-path">
                        <div class="container">
                            <div class="alert alert-danger" role="alert">@lang('ws.no_mentors')</div>
                        </div>
                    </section>
                @endif
            </div>
            {{$mentors->links('WS.partials.pagination')}}
        </div>
    </section>
@endsection
