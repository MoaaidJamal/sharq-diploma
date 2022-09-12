@extends('CP.layouts.main')

@section('title')
    @lang($module.'.title')
@endsection

@section($parent_module . '_menu')
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
                                <a href="{{route($parent_module)}}" class="text-muted">@lang($parent_module.'.title')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route($parent_module.'.'.$module, ['id' => $parent->id])}}" class="text-muted">@lang($module.'.title')</a>
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
                                <h3 class="card-title">@lang($module.'.title') || {{$parent->name}}</h3>
                                <div class="card-toolbar">
                                    <a href="javascript:;" onclick="showModal('{{route('users.'.$module.'.show_form', ['user_id' => $parent->id])}}')" type="button" class="btn btn-primary" id="add_edit_btn">
                                        <i class="flaticon-plus"></i>@lang('constants.new')
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        <div class="row">

                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                <div class="row">
                                                    <label class="col-md-12" for="date_search">@lang($module.'.date')</label>
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control my-daterangepicker-time" name="date" id="date_search" placeholder="@lang($module.'.date')">
                                                    </div>
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
                                <button class="btn btn-danger" onclick="delete_items(null, '{{route($parent_module.'.'.$module.'.delete')}}')">@lang('constants.deleteAll')</button>
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
                                        <th>@lang($module.'.date_from')</th>
                                        <th>@lang($module.'.date_to')</th>
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
            let datatable = $('#items_table').DataTable({
                "dom": 'tpi',
                "scrollX": isMobile,
                "searching": false,
                "processing": true,
                'stateSave': true,
                "serverSide": true,
                ajax: {
                    url: '{{route($parent_module.'.'.$module.'.list', ['id' => $parent->id])}}',
                    type: 'GET',
                    "data": function (d) {
                        d.date = $('#date_search').val();
                    }
                },
                columns: [
                    {className: 'text-center', data: 'check', name: 'check', orderable: false},
                    {className: 'text-center', data: 'date_from', name: 'date_from'},
                    {className: 'text-center', data: 'date_to', name: 'date_to'},
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
                $('#date_search').val('');

                $('#items_table').DataTable().ajax.reload(null, false);
            });
        });
    </script>
@endsection
