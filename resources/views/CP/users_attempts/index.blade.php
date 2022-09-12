@extends('CP.layouts.main')

@section('title')
    @lang($module.'.title')
@endsection

@section('courses_menu')
    menu-item-active
@endsection

@section('course_settings_menu')
    menu-item-active
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('body')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h5 class="text-dark font-weight-bold my-2 mr-5">@lang($module.'.title')</h5>
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{route($grandparent_module)}}" class="text-muted">@lang($grandparent_module . '.title')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route($grandparent_module.'.'.$parent_module, ['id' => $parent->course->id])}}" class="text-muted">@lang($parent_module.'.title')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route($grandparent_module.'.'.$parent_module.'.'.$module, ['id' => $parent->id])}}" class="text-muted">@lang($module.'.title')</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-custom gutter-b example example-compact">
                            <div class="card-header">
                                <h3 class="card-title">@lang($module.'.title') || {{$parent->title}}</h3>
                            </div>
                            <div class="card-body">
                                <button class="btn btn-danger" onclick="delete_items(null, '{{route($grandparent_module.'.'.$parent_module.'.'.$module.'.delete')}}')">@lang('constants.deleteAll')</button>
                                <br>
                                <br>
                                <table class="table" id="items_table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <label class="checkbox checkbox-single">
                                                <input type="checkbox" value="" class="group-checkable" id="selectAll"/>
                                                <span></span>
                                            </label>
                                        </th>
                                        <th>@lang($module.'.user_id')</th>
                                        <th>@lang($module.'.mark')</th>
                                        <th>@lang('constants.options')</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"></div>

@endsection
@section('js')
    <script>
        $(function () {
            $('#items_table').DataTable({
                "dom": 'tpi',
                "scrollX": isMobile,
                "searching": false,
                "processing": true,
                'stateSave': true,
                "serverSide": true,
                ajax: {
                    url: '{{route($grandparent_module.'.'.$parent_module.'.'.$module.'.list', ['id' => $parent->id])}}',
                    type: 'GET',
                    "data": function (d) {
                        d.question = $('#question').val();
                    }
                },
                columns: [
                    {className: 'text-center', data: 'check', name: 'check', orderable: false},
                    {className: 'text-center', data: 'user_id', name: 'user_id'},
                    {className: 'text-center', data: 'mark', name: 'mark'},
                    {className: 'text-center', data: 'actions', name: 'actions', orderable: false},
                ],
                @if(locale() == 'ar')
                language: {
                    "url": "{{url('/')}}/assets/plugins/custom/datatables/Arabic.json"
                },
                @endif
            });
        });
    </script>
@endsection
