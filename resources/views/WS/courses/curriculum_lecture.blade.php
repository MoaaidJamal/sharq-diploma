<li class="@if($group_lecture->id == $lecture->id) active @endif @if($group_lecture->is_user_lecture()) done @endif">
    @if($group_lecture->is_user_lecture())
        <label class="checkmarkCont">
            <input type="checkbox" checked="checked" disabled>
            <span class="checkmark"></span>
        </label>
    @else
        @if($group_lecture->id == $lecture->id)
            <form action="{{route('ws.complete_lecture')}}" method="post" enctype="multipart/form-data" class="complete_lecture">
                @csrf
                <input type="hidden" name="lecture_id" value="{{$lecture->id}}">
                <label class="checkmarkCont">
                    <input type="checkbox" disabled>
                    <span class="checkmark"></span>
                </label>
            </form>
        @else
            <label class="checkmarkCont">
                <input type="checkbox" disabled>
                <span class="checkmark"></span>
            </label>
        @endif
    @endif
    <a href="{{route('ws.course.show', ['course_id' => $course->id, 'lecture_id' => $group_lecture->id])}}">
        {{$group_lecture->title}}
        @if(in_array($group_lecture->category_id, [\App\Models\Lecture::CATEGORY_QUIZ, \App\Models\Lecture::CATEGORY_LIVE_SESSION]))
            <i><img src="{{url('/')}}/ws_assets/images/elearning.svg" alt=""></i>
        @elseif(in_array($group_lecture->category_id, [\App\Models\Lecture::CATEGORY_ASSIGNMENT, \App\Models\Lecture::CATEGORY_PANEL_DISCUSSION, \App\Models\Lecture::CATEGORY_BOOK_DISCUSSION]))
            <i><img src="{{url('/')}}/ws_assets/images/homework.svg" alt=""></i>
        @elseif($group_lecture->category_id == \App\Models\Lecture::CATEGORY_RECORDED_SESSION)
            <i><img src="{{url('/')}}/ws_assets/images/downloading.svg" alt=""></i>
        @elseif($group_lecture->category_id == \App\Models\Lecture::CATEGORY_ZOOM)
            <i><img src="{{url('/')}}/ws_assets/images/Path 72.svg" alt=""></i>
        @else
            @if(in_array($group_lecture->file_type, [1,2]))
                <i><img src="{{url('/')}}/ws_assets/images/video-player.svg" alt=""></i>
            @else
                <i><img src="{{url('/')}}/ws_assets/images/text-format.svg" alt=""></i>
            @endif
        @endif
    </a>
    @if(!in_array($group_lecture->category_id, [\App\Models\Lecture::CATEGORY_ASSIGNMENT, \App\Models\Lecture::CATEGORY_QUIZ]) && $group_lecture->minutes)
        <span class="courseTime">{{$group_lecture->minutes . 'm'}}</span>
    @endif
</li>
