@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">All employee List</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">employee</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            @if (in_array('hris.employee.create', $permissions) && auth()->user()->branch_id)
                <a href="{{ route('hris.employee.create') }}" style="float: right" type="button" class="btn btn-primary">
                    + Employee
                </a>
            @endif
        </section>

        <!-- Main content -->
        <section class="content" style="margin-top: 35px;">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="employeeTable" class="table order-column hover companyTable" style="width:100%">
                        <thead>
                            <tr class="bg-grey">
                                <th>SN. Number</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Shift</th>
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


@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <style>
        .form-group {
            margin-bottom: 0rem;
        }
    </style>
@stop

@section('js')
    <script>
        let listUrl = "{{ route('hris.employee.list') }}";
        let editUrl = "{{ route('hris.employee.edit') }}";
        let updateUrl = "{{ route('hris.employee.update') }}";
        let storeUrl = "{{ route('hris.employee.store') }}";
        let token = "{{ csrf_token() }}";
    </script>

    <script src="{{ asset('js/backend/hris/employee_index.js') }}"></script>
@stop
