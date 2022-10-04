<div data-repeater-item @if(isset($is_template) && $is_template) style="display: none" @endif>
    @if($item)
        <input type="hidden" name="id" value="{{ $item->id }}">
    @endif
    <div class="row border-bottom mb-3">
        <div class="form-group col-12">
            <div class="row">
                <label class="col-12" for="question">@lang($module.'.question') <span class="text-danger">*</span></label>
                <div class="col-12">
                    <textarea rows="6" name="question" id="question" required class="form-control">@if($item){{$item->question}}@endif</textarea>
                </div>
            </div>
        </div>
        <div class="form-group col-lg-6 col-sm-12">
            <div class="row">
                <label class="col-12" for="answer1">@lang($module.'.answer1') <span class="text-danger">*</span></label>
                <div class="col-12">
                    <input type="text" name="answer1" id="answer1" class="form-control" required placeholder="@lang($module.'.answer1')" @if($item) value="{{$item->answer1}}" @endif>
                </div>
            </div>
        </div>
        <div class="form-group col-lg-6 col-sm-12">
            <div class="row">
                <label class="col-12" for="answer2">@lang($module.'.answer2') <span class="text-danger">*</span></label>
                <div class="col-12">
                    <input type="text" name="answer2" id="answer2" class="form-control" required placeholder="@lang($module.'.answer2')" @if($item) value="{{$item->answer2}}" @endif>
                </div>
            </div>
        </div>
        <div class="form-group col-lg-6 col-sm-12">
            <div class="row">
                <label class="col-12" for="answer3">@lang($module.'.answer3')</label>
                <div class="col-12">
                    <input type="text" name="answer3" id="answer3" class="form-control" placeholder="@lang($module.'.answer3')" @if($item) value="{{$item->answer3}}" @endif>
                </div>
            </div>
        </div>
        <div class="form-group col-lg-6 col-sm-12">
            <div class="row">
                <label class="col-12" for="answer4">@lang($module.'.answer4')</label>
                <div class="col-12">
                    <input type="text" name="answer4" id="answer4" class="form-control" placeholder="@lang($module.'.answer4')" @if($item) value="{{$item->answer4}}" @endif>
                </div>
            </div>
        </div>
        <div class="form-group col-lg-6 col-sm-12">
            <div class="row">
                <label class="col-12" for="correct_answer">@lang($module.'.correct_answer') <span class="text-danger">*</span></label>
                <div class="col-12">
                    <select name="correct_answer" id="correct_answer" class="form-control" required>
                        <option selected value="">--</option>
                        <option value="1" @if(isset($item) && $item->correct_answer == 1) selected @endif>@lang($module.'.answer1')</option>
                        <option value="2" @if(isset($item) && $item->correct_answer == 2) selected @endif>@lang($module.'.answer2')</option>
                        <option value="3" @if(isset($item) && $item->correct_answer == 3) selected @endif>@lang($module.'.answer3')</option>
                        <option value="4" @if(isset($item) && $item->correct_answer == 4) selected @endif>@lang($module.'.answer4')</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-12">
            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                <i class="la la-trash-o"></i>
            </a>
        </div>
    </div>
</div>
