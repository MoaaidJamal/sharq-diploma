@extends('CP.layouts.main')

@section('title')
    @lang($module.'.title')
@endsection

@section($module.'_menu')
    menu-item-active
@endsection

@section('all_settings_menu')
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
                                <a href="{{route($module)}}" class="text-muted">@lang($module.'.title')</a>
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
                                <h3 class="card-title">@lang($module.'.title')</h3>
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-primary" id="add_edit_btn" onclick="showModal('{{ route($module.'.show_form')}}')">
                                        <i class="flaticon-plus"></i>@lang('constants.new')
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                <div class="row">
                                                    <label class="col-12" for="course_id">@lang($module.'.course_id')</label>
                                                    <div class="col-12">
                                                        <select name="course_id" id="course_id" class="selectpicker form-control" data-live-search="true">
                                                            <option selected value="">--</option>
                                                            @foreach($courses as $item)
                                                                <option value="{{$item->id}}">{{$item->title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-12 text-danger" id="course_id_error"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                <div class="row">
                                                    <label class="col-12" for="user_id">@lang($module.'.user_id')</label>
                                                    <div class="col-12">
                                                        <select name="user_id" id="user_id" class="selectpicker form-control" data-live-search="true">
                                                            <option selected value="">--</option>
                                                            @foreach($users as $item)
                                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-12 text-danger" id="user_id_error"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <button style="margin-top:30px; width: 100%" class="btn btn-primary search_btn"><i class="icon-line-search"></i> @lang('constants.search')</button>
                                            </div>

                                            <div class="col-md-3 form-group">
                                                <button style="margin-top:30px; width: 100%" class="btn btn-secondary reset_search"><i class="icon-refresh2"></i> @lang('constants.cancel')</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <button id="btn_show_search_box" onclick="check_collapse()" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="flaticon-search"></i>
                                    @lang('constants.showSearch')
                                </button>
                                <br>
                                <br>
                                <button class="btn btn-danger" onclick="delete_items(null, '{{route($module.'.delete')}}')">@lang('constants.deleteAll')</button>
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
                                        <th>@lang($module.'.course_id')</th>
                                        <th>@lang($module.'.grade1')</th>
                                        <th>@lang($module.'.grade2')</th>
                                        <th>@lang($module.'.grade3')</th>
                                        <th>@lang($module.'.grade4')</th>
                                        <th>@lang($module.'.grade5')</th>
                                        <th>@lang('constants.isEnable')</th>
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
                    url: '{{route($module.'.list')}}',
                    type: 'GET',
                    "data": function (d) {
                        d.course_id = $('#course_id').val();
                        d.user_id = $('#user_id').val();
                    }
                },
                columns: [
                    {className: 'text-center', data: 'check', name: 'check', orderable: false},
                    {className: 'text-center', data: 'user', name: 'user'},
                    {className: 'text-center', data: 'course', name: 'course'},
                    {className: 'text-center', data: 'grade1', name: 'grade1'},
                    {className: 'text-center', data: 'grade2', name: 'grade2'},
                    {className: 'text-center', data: 'grade3', name: 'grade3'},
                    {className: 'text-center', data: 'grade4', name: 'grade4'},
                    {className: 'text-center', data: 'grade5', name: 'grade5'},
                    {className: 'text-center', data: 'enabled', name: 'enabled', orderable: false},
                    {className: 'text-center', data: 'actions', name: 'actions', orderable: false},
                ],
                @if(locale() == 'ar')
                language: {
                    "url": "{{url('/')}}/assets/plugins/custom/datatables/Arabic.json"
                },
                @endif
            });

            $('.search_btn').click(function (ev) {
                $('#items_table').DataTable().ajax.reload(null, false);
            });

            $('.reset_search').click(function () {
                $('#course_id').val('').trigger('change');
                $('#user_id').val('').trigger('change');

                $('#items_table').DataTable().ajax.reload(null, false);
            });
        });
    </script>
@endsection
