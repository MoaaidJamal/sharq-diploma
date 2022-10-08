<div class="reviewNum">
    <div class="revNumm">
        <p> {{round($course->reviews()->avg('rate'), 2) ?: 0}}</p><span>@lang('ws.out_of') 5</span>
    </div>
    <p> <span class="learnerReviewsReadOnly" data-rating="{{$course->reviews()->avg('rate') ?: 0}}"></span>
        <span class="ratingsNumber">{{$course->reviews()->count()}} @lang('ws.ratings')</span>
    </p>
</div>
<div class="reviewsDet">
    @php($stars5 = $course->reviews()->count() ? round($course->reviews()->where('rate', '>=', 4.5)->count() / $course->reviews()->count() * 100, 2) : 0)
    @php($stars4 = $course->reviews()->count() ? round($course->reviews()->where('rate', '>=', 3.5)->where('rate', '<', 4.5)->count() / $course->reviews()->count() * 100, 2) : 0)
    @php($stars3 = $course->reviews()->count() ? round($course->reviews()->where('rate', '>=', 2.5)->where('rate', '<', 3.5)->count() / $course->reviews()->count() * 100, 2) : 0)
    @php($stars2 = $course->reviews()->count() ? round($course->reviews()->where('rate', '>=', 1.5)->where('rate', '<', 2.5)->count() / $course->reviews()->count() * 100, 2) : 0)
    @php($stars1 = $course->reviews()->count() ? round($course->reviews()->where('rate', '>=', 0.5)->where('rate', '<', 1.5)->count() / $course->reviews()->count() * 100, 2) : 0)
    <div class=" reviewProg clearfix">
        <span>5 @lang('ws.stars')</span>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{$stars5}}%;"
                 aria-valuenow="{{$stars5}}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <span>{{$stars5}}%</span>
    </div>
    <div class=" reviewProg clearfix">
        <span>4 @lang('ws.stars')</span>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{$stars4}}%;"
                 aria-valuenow="{{$stars4}}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <span>{{$stars4}}%</span>
    </div>

    <div class=" reviewProg clearfix">
        <span>3 @lang('ws.stars')</span>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{$stars3}}%;"
                 aria-valuenow="{{$stars3}}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <span>{{$stars3}}%</span>
    </div>
    <div class=" reviewProg clearfix">
        <span>2 @lang('ws.stars')</span>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{$stars2}}%;"
                 aria-valuenow="{{$stars2}}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <span>{{$stars2}}%</span>
    </div>
    <div class=" reviewProg clearfix">
        <span>1 @lang('ws.star')</span>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{$stars1}}%;"
                 aria-valuenow="{{$stars1}}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <span>{{$stars1}}%</span>
    </div>
</div>
