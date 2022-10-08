<a href="{{route('ws.user_profile', ['id' => $user->id])}}">
    <div class="InstructorItem">
        <div class="instructorImg">
            <img src="{{$user->full_path_image}}" alt="">

        </div>
        <div class="instructorSecDetails">
            @if($user->country)
                <div class="flagIcon">
                    <img alt="img" src="{{$user->country->image}}"/>
                </div>
            @endif
            <h4>{{$user->name}}</h4>
            <ul class=" instructorSocial">
                @if($user->facebook)
                    <li>
                        <a href="{{$user->facebook}}"><i class="fab fa-facebook-f"></i></a>
                    </li>
                @endif
                @if($user->instagram)
                    <li>
                        <a href="{{$user->instagram}}"><i class="fab fa-instagram"></i></a>
                    </li>
                @endif
                @if($user->twitter)
                    <li>
                        <a href="{{$user->twitter}}"><i class="fab fa-twitter"></i></a>
                    </li>
                @endif
                @if($user->linkedin)
                    <li>
                        <a href="{{$user->linkedin}}"><i class="fab fa-linkedin-in"></i></a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</a>
