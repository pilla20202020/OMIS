@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">All Role List</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('config.dashboard.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Role</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            @if (in_array('hris.role.create', $permissions) && auth()->user()->company_id)
                <a  href="{{route('hris.role.create')}}" style="float: right" type="button" class="btn btn-primary">
                    + Role
                </a>
            @endif
        </section>

        <!-- Main content -->
        <section class="content" style="margin-top: 35px;">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="roleTable" class="table order-column hover companyTable" style="width:100%">
                        <thead>
                            <tr class="bg-grey">
                                <th>S.N.</th>
                                <th>Role Name</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>


    <!-- /.modal start for Add role-->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0rem">
                    <form action="#" method="post" id="modalForm">
                        @csrf
                        <input type="hidden" name="emp_id" id="emp_id">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="role_type">role Name</label>
                                <input type="text" class="form-control" id="role_type" name="role_type"
                                    placeholder="Enter role Name">
                            </div>
                            <div class="form-group">
                                <label>Start Time:</label>
                                <div class="input-group date" id="timepicker" data-target-input="nearest">
                                    <input type="text" name="start_role" id="start_role"
                                        class="form-control datetimepicker-input" data-target="#timepicker" />
                                    <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>

                            <div class="form-group">
                                <label>End Time:</label>

                                <div class="input-group date" id="endtimepicker" data-target-input="nearest">
                                    <input type="text" name="end_role" id="end_role"
                                        class="form-control datetimepicker-input" data-target="#endtimepicker" />
                                    <div class="input-group-append" data-target="#endtimepicker"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>

                            <div class="form-group">
                                <label>Select Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option>Active</option>
                                    <option>Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal End -->


@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <style>

    </style>
@stop

@section('js')
    <script>
        let listUrl = "{{ route('hris.role.list') }}";
        let updateUrl = "{{ route('hris.role.update') }}";
        let storeUrl = "{{ route('hris.role.store') }}";
        let token = "{{ csrf_token() }}";
    </script>

    <script src="{{ asset('js/backend/hris/role_index.js') }}"></script>
@stop

