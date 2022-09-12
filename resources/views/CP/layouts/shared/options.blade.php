@if(!isset($without_placeholder) || (!$without_placeholder))
    <option selected value="">--</option>
@endif
@foreach($items as $item)
    <option value="{{$item->id}}">{{$item->{$name ?? 'name'} }}</option>
@endforeach
