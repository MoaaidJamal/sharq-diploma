<footer class="rtl">
    <div class="container d-flex flex-column align-items-center">
        <div class="d-flex justify-content-center align-items-center flex-wrap">
            <a href="{{route('ws.home')}}" class="font-bold700 font-inter font18 my-4 mx-3" style="padding: 0 !important">{{$settings->home_menu_title}}</a>
            <a href="{{route('ws.modules')}}" class="font-bold700 font-inter font18 my-4 mx-3" style="padding: 0 !important">{{$settings->learning_paths_menu_title}}</a>
            <a href="{{route('ws.teammates')}}" class="font-bold700 font-inter font18 my-4 mx-3" style="padding: 0 !important">{{$settings->find_your_mate_menu_title}}</a>
            <a href="{{route('ws.mentors')}}" class="font-bold700 font-inter font18 my-4 mx-3" style="padding: 0 !important">{{$settings->mentors_menu_title}}</a>
            <a href="{{route('ws.schedule')}}" class="font-bold700 font-inter font18 my-4 mx-3" style="padding: 0 !important">{{$settings->schedule_menu_title}}</a>
            <a href="{{route('ws.messages')}}" class="font-bold700 font-inter font18 my-4 mx-3" style="padding: 0 !important">{{$settings->messages_menu_title}}</a>
        </div>
        <hr style="background-color: #fff;" width="100%" />
        <div class="d-flex justify-content-between align-items-center w-100 flex-column flex-lg-row">
            <div class="font-inter text-f">{{$settings->copyright}}</div>
            <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                <div  class="mx-4 mt-2 font-inter text-f follow">{{$settings->follow_us_on_social_media}}</div>
                <div class="d-flex justify-content-between">
                    <a href="{{$settings->instagram}}" class="icon"><i class="bi bi-instagram"></i></a>
                    <a href="{{$settings->facebook}}" class="icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{$settings->twitter}}" class="icon"><i class="bi bi-twitter"></i></a>
                    <a href="{{$settings->linkedin}}" class="icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
