<div data-repeater-item @if(isset($is_template) && $is_template) style="display: none" @endif>
    @if($item)
        <input type="hidden" name="id" value="{{ $item->id }}">
    @endif
    <div class="row">
        <div class="form-group col-lg-5 col-sm-12">
            <div class="row">
                <label class="col-12 mb-2 px-5">@lang($module.'.title_ar')</label>
                <div class="col-12">
                    <input type="text" class="form-control" name="title_ar" required placeholder="@lang($module.'.title_ar')" @if($item) value="{{$item->getTranslation('title', 'ar')}}" @endif />
                </div>
                <div class="col-12 error-message text-danger mt-2 px-4"></div>
            </div>
        </div>
        <div class="form-group col-lg-5 col-sm-12">
            <div class="row">
                <label class="col-12 mb-2 px-5">@lang($module.'.title_en')</label>
                <div class="col-12">
                    <input type="text" class="form-control" name="title_en" required placeholder="@lang($module.'.title_en')" @if($item) value="{{$item->getTranslation('title', 'en')}}" @endif />
                </div>
                <div class="col-12 error-message text-danger mt-2 px-4"></div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-12">
            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                <i class="la la-trash-o"></i>
            </a>
        </div>
    </div>
</div>
