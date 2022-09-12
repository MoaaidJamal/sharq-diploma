<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Attempt By {{optional($record->user)->name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @foreach ($record->answers as $key => $answer)
                @if (!$answer->question) @continue @endif
                @php($question = $answer->question)
                <div class="row" style="padding-left: 10px;">
                    <div class="col-12">
                        {!! $question->question !!}
                    </div>
                    <div class="col-1"></div>
                    <div class="col-11" style="@if($question->correct_answer == 1) color: #39b550 @elseif($answer->answer == 1) color: #a10000 @endif">
                        {{$question->answer1}}
                    </div>
                    <div class="col-1"></div>
                    <div class="col-11" style="@if($question->correct_answer == 2) color: #39b550 @elseif($answer->answer == 2) color: #a10000 @endif">
                        {{$question->answer2}}
                    </div>
                    <div class="col-1"></div>
                    <div class="col-11" style="@if($question->correct_answer == 3) color: #39b550 @elseif($answer->answer == 3) color: #a10000 @endif">
                        {{$question->answer3}}
                    </div>
                    <div class="col-1"></div>
                    <div class="col-11" style="@if($question->correct_answer == 4) color: #39b550 @elseif($answer->answer == 4) color: #a10000 @endif">
                        {{$question->answer4}}
                    </div>
                </div>
                <hr style="width: 100%;">
            @endforeach
        </div>
    </div>
</div>
