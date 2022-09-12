<header class="d-flex justify-content-center">
    <nav class="container navbar navbar-expand-lg navbar-dark"
         style="box-shadow: none !important;">
        <div class="container-fluid rtl">
            <a class="navbar-brand" href="{{route('ws.home')}}"><img alt="img" src="{{url('/')}}/assets/images/logo.svg" style="@if(locale() == 'ar') margin-left: 20px; @else margin-right: 20px; @endif height: 60px; margin-top: -14px;" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav @if(locale() == 'ar') ms-auto @endif mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link @yield('home_active')" href="{{route('ws.home')}}">{{$settings->home_menu_title}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('module_active')" href="{{route('ws.modules')}}">{{$settings->learning_paths_menu_title}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('find_mates_active')" href="{{route('ws.teammates')}}">{{$settings->find_your_mate_menu_title}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('mentors_active')" href="{{route('ws.mentors')}}">{{$settings->mentors_menu_title}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('schedule_active')" href="{{route('ws.schedule')}}">{{$settings->schedule_menu_title}}</a>
                    </li>
                </ul>
                <ul class="navbar-nav @if(locale() == 'ar') me-auto @else ms-auto @endif mb-2 mb-lg-0 profile-menu">
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                {{\Illuminate\Support\Str::upper(locale())}}
                            </button>
                            <ul class="@if(locale() == 'ar') dropdown-menu-rtl @endif dropdown-menu w3-animate-opacity" aria-labelledby="dropdownMenuButton2">
                                <div class="arrow"><i class="bi bi-caret-up-fill"></i></div>
                                @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li><a class="dropdown-item font-bold700 font-inter small-text py-2" href="{{\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($localeCode, null, [], true)}}" hreflang="{{ $localeCode }}">{{ \Illuminate\Support\Str::upper($localeCode) }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{auth()->user()->full_path_image}}" style="max-width: 50px; max-height: 50px; border-radius: 50%"/>
                            </button>
                            <ul class="@if(locale() == 'ar') dropdown-menu-rtl @endif dropdown-menu w3-animate-opacity" aria-labelledby="dropdownMenuButton1">
                                <div class="arrow"><i class="bi bi-caret-up-fill"></i></div>
                                @if(in_array(auth()->user()->type, [1, 5]))
                                    <li><a class="dropdown-item font-bold700 font-inter small-text py-2" href="{{auth()->user()->type == 1 ? route('admin.dashboard') : route('user_grades')}}">@lang('ws.dashboard')</a></li>
                                @endif
                                <li><a class="dropdown-item font-bold700 font-inter small-text py-2" href="{{route('ws.profile')}}">@lang('ws.my_profile')</a></li>
                                <li><a class="dropdown-item logout font-bold700 font-inter small-text py-2" href="{{route('ws.logout')}}"><i class="bi bi-box-arrow-right"></i>@lang('ws.logout')</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</header>
