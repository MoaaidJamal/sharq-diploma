@extends('WS.layouts.main')

@section('title')
    {{$settings->find_your_mate_title}}
@endsection
@section('find_mates_active')
    active
@endsection

@section('body')
    <section class="coursesHeader">
        <div class="container">
            <div class="row ">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">{{$settings->home_menu_title}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$settings->find_your_mate_title}}</li>
                        </ol>
                    </nav>
                    <h5>
                        {{$settings->find_your_mate_title}}
                    </h5>
                    <p>
                        {{$settings->find_your_mate_description}}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <div class="ParticipantsFilter">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills  ParticipantsPills" id="nav-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if(!$interest_id) active @endif" href="{{route('ws.teammates')}}">
                                <span>@lang('ws.all')</span>
                            </a>
                        </li>
                        @foreach($interests as $interest)
                            <li class="nav-item">
                                <a class="nav-link @if($interest->id == $interest_id) active @endif"
                                   href="{{route('ws.teammates', ['interest_id' => $interest->id])}}">
                                    <span>{{$interest->name}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="Instructors instructorPageBody">
        <div class="container">
            <div class="row">
                @if(count($mates))
                    @foreach($mates as $mate)
                        <div class="col-md-3 col-6">
                            @include('WS.users.user_card', ['user' => $mate])
                        </div>
                    @endforeach
                @else
                    <section class="learning-path">
                        <div class="container">
                            <div class="alert alert-danger" role="alert">@lang('ws.no_teammates_to_show')</div>
                        </div>
                    </section>
                @endif
            </div>
            {{$mates->links('WS.partials.pagination')}}
        </div>
    </section>

@endsection
