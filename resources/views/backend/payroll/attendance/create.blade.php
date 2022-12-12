@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">Employees Attendance</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('payroll.attendance.store') }}" method="post" id="modalForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group ">
                                <label>Select Department</label>
                                <select class="form-control" name="dept_id" id="dept_id">
                                    <option value="All">All</option>
                                    @foreach ($departments as $item)
                                        <option value="{{ $item->dept_id }}"
                                            @if (request()->query('dept') == $item->dept_id) selected @endif>
                                            {{ $item->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group ">
                                <label>Select Shift</label>
                                <select class="form-control" name="shift_id" id="shift_id">
                                    <option value="All">All</option>
                                    @foreach ($shifts as $item)
                                        <option value="{{ $item->shift_id }}"
                                            @if (request()->query('shift') == $item->shift_id) selected @endif>
                                            {{ $item->shift_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="department_name">Date:</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    value="{{ request()->query('date') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Main content -->

                    <div class="row" style="margin-top: 25px;">
                        <div class="card" style="width: 100%">
                            <div class="card-header">
                                <h3 class="card-title">Enter Daily Employee Attendance </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Employee Name</th>
                                            <th style="width: 150px">Present Status</th>
                                            <th style="width: 150px">Leave Type</th>
                                            <th style="width: 150px">Late Minutes</th>
                                            <th style="width: 150px">Present Type</th>
                                            <th style="width: 300px">Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $serialNo = 1;
                                        @endphp
                                        @foreach ($employees as $employee)
                                            @php
                                                $attendance = \App\Models\Payroll\EmployeeAttendance::where('emp_id', $employee->emp_id)
                                                    ->where('date', request()->query('date'))
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $serialNo++ }}.</td>
                                                <td>
                                                    <input type="hidden" name="emp_id[{{ $employee->emp_id }}]"
                                                        value="{{ $employee->emp_id }}">
                                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                                </td>
                                                <td>
                                                    <select class="form-control custom_present"
                                                        name="status[{{ $employee->emp_id }}]"
                                                        data-emp_id="{{ $employee->emp_id }}">
                                                        <option value="P"
                                                            @if (isset($attendance) && $attendance->status == 'P') selected @endif>Present
                                                        </option>
                                                        <option value="A"
                                                            @if (isset($attendance) && $attendance->status == 'A') selected @endif>Absent
                                                        </option>
                                                        <option value="L"
                                                            @if (isset($attendance) && $attendance->status == 'L') selected @endif>Leave
                                                        </option>
                                                        <option
                                                            value="H"@if (isset($attendance) && $attendance->status == 'H') selected @endif>
                                                            Holiday
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control {{isset($attendance) && $attendance->status == 'L'? '' : 'd-none'}} leave_type{{ $employee->emp_id }}"
                                                        name="leave_type_id[{{ $employee->emp_id }}]">
                                                        <option value="">Leave Type</option>
                                                        @foreach ($leaveTypes as $leaveType)
                                                            <option value="{{ $leaveType->id }}"
                                                                @if (isset($attendance) && $attendance->leave_type_id == $leaveType->id) selected @endif>
                                                                {{ $leaveType->leave_type }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                        name="late_minute[{{ $employee->emp_id }}]"
                                                        @if (isset($attendance) && $attendance->late_minute) value="{{ $attendance->late_minute }}" @endif>

                                                </td>
                                                <td>
                                                    <select class="form-control"
                                                        name="present_type[{{ $employee->emp_id }}]">
                                                        <option value="Full"
                                                            @if (isset($attendance) && $attendance->present_type == 'Full') selected @endif>Full Day
                                                        </option>
                                                        <option
                                                            value="Half"@if (isset($attendance) && $attendance->present_type == 'Half') selected @endif>
                                                            Half Day</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        name="reason[{{ $employee->emp_id }}]"
                                                        @if (isset($attendance) && $attendance->reason) value="{{ $attendance->reason }}" @endif>

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            {{-- <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    <!-- /.card -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </section>
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
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script>
        let listUrl = "{{ route('payroll.attendance.list') }}";
        let editUrl = "{{ route('payroll.attendance.edit') }}";
        let updateUrl = "{{ route('payroll.attendance.update') }}";
        let storeUrl = "{{ route('payroll.attendance.store') }}";
        let token = "{{ csrf_token() }}";

        $(document).ready(function() {
            $(document).on('change', '#dept_id', function(e) {
                let dept = $(this).val();
                let url = new URL(window.location.href);
                url.searchParams.set("dept", dept); // setting your param
                let newUrl = url.href;
                window.location.href = newUrl;

            })

            $(document).on('change', '#shift_id', function(e) {
                let shift = $(this).val();
                let url = new URL(window.location.href);
                url.searchParams.set("shift", shift); // setting your param
                let newUrl = url.href;
                window.location.href = newUrl;

            })

            $(document).on('change', '#date', function(e) {
                let date = $(this).val();
                let url = new URL(window.location.href);
                url.searchParams.set("date", date); // setting your param
                let newUrl = url.href;
                window.location.href = newUrl;

            })

            $(document).on('change', '.custom_present', function(e) {
                let leave_type = $(this).val();
                let emp_id = $(this).data('emp_id');
                if (leave_type == 'L') {
                    $('.leave_type' + emp_id).removeClass('d-none');
                } else {
                    $('.leave_type' + emp_id).val('');
                    $('.leave_type' + emp_id).addClass('d-none');
                }


            })


        })
    </script>

    <script src="{{ asset('js/backend/payroll/attendance_index.js') }}"></script>
@stop
