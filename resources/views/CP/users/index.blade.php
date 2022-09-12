@extends('CP.layouts.main')
@section('title')
    @lang($module.'.title')
@endsection

@section($module.'_menu')
    menu-item-active
@endsection

@section('all_users_menu')
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
                                    <a href="{{ route($module.'.show_form')}}" class="btn btn-primary" id="add_edit_btn">
                                        <i class="flaticon-plus"></i>@lang('constants.new')
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        <div class="row">
                                            <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <label class="col-md-12" for="name">@lang($module.'.name')</label>
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control" name="name" id="name" placeholder="@lang($module.'.name')">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <label class="col-md-12" for="email_search">@lang($module.'.email')</label>
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control" name="email" id="email_search" placeholder="@lang($module.'.email')">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <label class="col-md-12" for="mobile_search">@lang($module.'.mobile')</label>
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control" name="mobile" id="mobile_search" placeholder="@lang($module.'.mobile')">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <label class="col-12" for="type">@lang($module.'.type') <span class="text-danger">*</span></label>
                                                    <div class="col-12">
                                                        <select name="type" id="type" class="selectpicker form-control" data-live-search="true">
                                                            <option selected value="">--</option>
                                                            <option value="1" @if(request('type') == 1) selected @endif>@lang($module.'.admin')</option>
                                                            <option value="2" @if(request('type') == 2) selected @endif>@lang($module.'.user')</option>
                                                            <option value="3" @if(request('type') == 3) selected @endif>@lang($module.'.mentor')</option>
                                                            <option value="4" @if(request('type') == 4) selected @endif>@lang($module.'.team')</option>
                                                            <option value="5" @if(request('type') == 5) selected @endif>@lang($module.'.lecturer')</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 text-danger" id="type_error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <button style="margin-top:30px; width: 100%" class="btn btn-primary search_btn"><i class="icon-line-search"></i> @lang('constants.search')</button>
                                            </div>

                                            <div class="form-group col-md-3">
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
                                        <th>@lang($module.'.name')</th>
                                        <th>@lang($module.'.email')</th>
                                        <th>@lang($module.'.mobile')</th>
                                        <th>@lang($module.'.image')</th>
                                        <th>@lang($module.'.type')</th>
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
                        d.name = $('#name').val();
                        d.email = $('#email_search').val();
                        d.mobile = $('#mobile_search').val();
                        d.type = $('#type').val();
                    }
                },
                columns: [
                    {className: 'text-center', data: 'check', name: 'check', orderable: false},
                    {className: 'text-center', data: 'name', name: 'name'},
                    {className: 'text-center', data: 'email', name: 'email'},
                    {className: 'text-center', data: 'mobile', name: 'mobile'},
                    {className: 'text-center', data: 'image', name: 'image'},
                    {className: 'text-center', data: 'type', name: 'type'},
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
                $('#name').val('');
                $('#email_search').val('');
                $('#mobile_search').val('');
                $('#type').val('').trigger('change');

                $('#items_table').DataTable().ajax.reload(null, false);
            });
        });

        function send_verification_link(id) {
            Swal.fire({
                title: '@lang($module.'.send_verification_link?')',
                text: "@lang('constants.sure')",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#84dc61',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang('constants.yes')',
                cancelButtonText: '@lang('constants.no')'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{route($module.'.send_verification_link')}}',
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': id
                        },
                        beforeSend(){
                            KTApp.blockPage({
                                overlayColor: '#000000',
                                type: 'v2',
                                state: 'success',
                                message: '@lang('constants.please_wait') ...'
                            });
                        },
                        success: function (data) {
                            if (data.success) {
                                $('#items_table').DataTable().ajax.reload(null, false);
                                showAlertMessage('success', data.message);
                            } else {
                                showAlertMessage('error', '@lang('constants.unknown_error')');
                            }
                            KTApp.unblockPage();
                        },
                        error: function (data) {
                            console.log(data);
                        },
                    });
                }
            });
        }
    </script>
@endsection
