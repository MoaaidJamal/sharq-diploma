@extends('CP.layouts.main')

@section('title')
    @lang($module.'.title')
@endsection

@section('courses_menu')
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
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-primary" id="add_edit_btn" onclick="showModal('{{ route($grandparent_module.'.'.$parent_module.'.'.$module.'.show_form', ['course_id' => $course_id, 'lecture_id' => $lecture_id])}}')">
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
                                                    <label class="col-md-12" for="question">@lang($module.'.question')</label>
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control" name="question" id="question" placeholder="@lang($module.'.question')">
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
                                <button id="btn_show_search_box" onclick="check_collapse()" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample"
                                        aria-expanded="false" aria-controls="collapseExample">
                                    <i class="flaticon-search"></i>
                                    @lang('constants.showSearch')
                                </button>
                                <br>
                                <br>
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
                                        <th>@lang($module.'.question')</th>
                                        <th>@lang($module.'.order')</th>
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
                    url: '{{route($grandparent_module.'.'.$parent_module.'.'.$module.'.list', ['id' => $parent->id])}}',
                    type: 'GET',
                    "data": function (d) {
                        d.question = $('#question').val();
                    }
                },
                columns: [
                    {className: 'text-center', data: 'check', name: 'check', orderable: false},
                    {className: 'text-center cursor-pointer', data: 'question', name: 'question'},
                    {className: 'text-center cursor-pointer', data: 'order', name: 'order'},
                    {className: 'text-center', data: 'enabled', name: 'enabled', orderable: false},
                    {className: 'text-center', data: 'actions', name: 'actions', orderable: false},
                ],
                rowReorder: {
                    selector: 'tr td:not(:first-of-type,:nth-last-child(2),:last-of-type)',
                    dataSrc: 'order'
                },
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
                $('#question').val('');

                $('#items_table').DataTable().ajax.reload(null, false);
            });

            datatable.on('row-reorder', function (e, details) {
                if(details.length) {
                    let rows = [];
                    details.forEach(element => {
                        rows.push({
                            id: datatable.row(element.node).data().id,
                            order: element.newPosition + 1
                        });
                    });

                    $.ajax({
                        method: 'POST',
                        beforeSend() {
                            KTApp.blockPage({
                                overlayColor: '#000000',
                                type: 'v2',
                                state: 'success',
                                message: '@lang('constants.please_wait') ...'
                            });
                        },
                        url: "{{ route($grandparent_module.'.'.$parent_module.'.'.$module.'.reorder') }}",
                        data: { rows }
                    }).done(function () {
                        $('#items_table').DataTable().ajax.reload(null, false);
                        KTApp.unblockPage();
                    });
                }
            });
        });
    </script>
@endsection
