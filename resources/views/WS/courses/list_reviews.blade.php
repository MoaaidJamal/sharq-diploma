@foreach($reviews as $item)
    <li>
        <article class="review-item media">
            <img src="{{@$item->user->full_path_image}}" alt="{{@$item->user->name}}" style="max-height: 150px; max-width: 150px">
            <div class="media-body">
                <div class="d-flex justify-content-between">
                    <div class="review-author">
                        <p>{{@$item->user->name}}</p>
                        <p class="rating">
                            <i class="fa fa-star{{$item->rate < 0.5 ? '-o' : ''}} fa-fw"></i>
                            <i class="fa fa-star{{$item->rate < 1.5 ? '-o' : ''}} fa-fw"></i>
                            <i class="fa fa-star{{$item->rate < 2.5 ? '-o' : ''}} fa-fw"></i>
                            <i class="fa fa-star{{$item->rate < 3.5 ? '-o' : ''}} fa-fw"></i>
                            <i class="fa fa-star{{$item->rate < 4.5 ? '-o' : ''}} fa-fw"></i>
                        </p>
                    </div>
                    <div class="d-flex">
                        <p class="date">{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</p>
                        <buttn class="btn btn-outline-danger delete_review" data-id="{{$item->id}}"><i class="fa fa-trash"></i></buttn>
                    </div>
                </div>
                <div class="content">
                    <p>
                        {{$item->comment}}
                    </p>
                </div>
            </div>
        </article>
    </li>
@endforeach
