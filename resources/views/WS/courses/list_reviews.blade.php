@foreach($reviews as $item)
    <div class="learnerReviewBox">
        <div class="reviewerDetails clearfix">
            <div class="reviewerImg">
                <img src="{{$item->user ? $item->user->full_path_image : ''}}" alt="">
            </div>
            <div class="reviewerName">
                <h6 class="aboutCourseTitle">
                    {{$item->user ? $item->user->name : ''}}
                </h6>
                <p class="aboutCoursePar">{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</p>
            </div>
        </div>
        <div class="learnerReviewRate">
            <span class="learnerReviewsReadOnly"
                                             data-rating="{{$item->rate}}"></span>
            <span class="ratingsNumber">{{$item->rate}}</span>
        </div>
        <p class="aboutCoursePar">{{$item->comment}}</p>
        <a href="javascript:;" class="reviewHelpful delete_review" data-id="{{$item->id}}">
            <span>
                <i class="fas fa-trash text-danger"></i>
            </span>
        </a>
    </div>
@endforeach
