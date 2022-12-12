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
                            <div class="form-group">
                                <label for="department_name">Date:</label>
                                <input type="date" class="form-control" id="date" name="start_date"
                                    value="{{ request()->query('start_date') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="department_name">Date:</label>
                                <input type="date" class="form-control" id="date" name="end_date"
                                    value="{{ request()->query('end_date') }}">
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-top: 32px">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>

                    <!-- Main content -->


                </form>

            </div>
        </section>
        <!-- Main content -->
        <section class="content" style="margin-top: 35px;">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="employeeTable" class="table order-column hover companyTable" style="width:100%">
                        <thead>
                            <tr class="bg-grey">
                                <th>S.N.</th>
                                <th>Employee Name</th>
                                @php
                                    $initialStart = request()->query('start_date');
                                    $start_date = strtotime(request()->query('start_date'));
                                    $end_date = strtotime(request()->query('end_date'));
                                @endphp
                                @for ($i = 1; $end_date >= $start_date; $i++)
                                    @php
                                        $start_date = date('Y-m-d', $start_date);
                                        $start_date = strtotime($initialStart . "+$i day");
                                    @endphp
                                    <th>{{ $i }}</th>
                                @endfor
                                <th>Total Days</th>
                                <th>Holiday</th>
                                <th>Working Day</th>
                                <th>Worked Day</th>
                                <th>Total Worked Day</th>
                                <th>Absent and Leave days</th>
                                <th>Total Absent and Leave</th>
                                <th>Late Days</th>
                            </tr>


                        </thead>
                        <tbody>
                            @php
                                $tattendance = [];
                                $initial = 1;
                            @endphp
                            @if (!empty($employees) && count($employees) > 1)
                                @foreach ($employees as $employee)
                                    <tr>
                                        @php
                                            $initialStart = request()->query('start_date');
                                            $start_date = strtotime(request()->query('start_date'));
                                            $end_date = strtotime(request()->query('end_date'));
                                        @endphp
                                        <td>{{ $initial++ }}</td>
                                        <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                        @for ($i = 1; $end_date >= $start_date; $i++)
                                            @php
                                                $start_date = date('Y-m-d', $start_date);
                                                $attendance = \App\Models\Payroll\EmployeeAttendance::where('emp_id', $employee->emp_id)
                                                    ->where('date', $start_date)
                                                    ->first();
                                                // dd($employee->emp_id,$start_date);
                                                // $tattendance[$initial][$start_date] = [$attendance];
                                                $start_date = strtotime($initialStart . "+$i day");
                                            @endphp
                                            <td>{{ $attendance ? $attendance->status : 'UN' }}</td>
                                        @endfor
                                        <td>
                                            @php
                                                $totalDays = \App\Models\Payroll\EmployeeAttendance::where('emp_id', $employee->emp_id)
                                                    ->whereBetween('date', [request()->query('start_date'), request()->query('end_date')])
                                                    ->count('emp_id');
                                            @endphp
                                            {{ $totalDays }}
                                        </td>
                                        <td>
                                            @php
                                                $totalHoliday = \App\Models\Payroll\EmployeeAttendance::where('emp_id', $employee->emp_id)
                                                    ->whereBetween('date', [request()->query('start_date'), request()->query('end_date')])
                                                    ->where('status', 'H')
                                                    ->count('emp_id');
                                            @endphp
                                            {{ $totalHoliday }}
                                        </td>
                                        <td>
                                            {{ $totalDays - $totalHoliday }}
                                        </td>
                                        <td>
                                            @php
                                                $fullWorkDay = \App\Models\Payroll\EmployeeAttendance::where('emp_id', $employee->emp_id)
                                                    ->whereBetween('date', [request()->query('start_date'), request()->query('end_date')])
                                                    ->where('status', 'P')
                                                    ->where('present_type', 'Full')
                                                    ->count('emp_id');
                                                $halfWorkDay = \App\Models\Payroll\EmployeeAttendance::where('emp_id', $employee->emp_id)
                                                    ->whereBetween('date', [request()->query('start_date'), request()->query('end_date')])
                                                    ->where('status', 'P')
                                                    ->where('present_type', 'Half')
                                                    ->count('emp_id');
                                            @endphp
                                            Full Day ={{ $fullWorkDay }} + Half Day ={{ $halfWorkDay }}
                                        </td>
                                        <td>
                                            {{ $fullWorkDay + $halfWorkDay / 2 }}
                                        </td>
                                        <td>
                                            @php
                                                $halfLeaveDay = \App\Models\Payroll\EmployeeAttendance::where('emp_id', $employee->emp_id)
                                                    ->whereBetween('date', [request()->query('start_date'), request()->query('end_date')])
                                                    ->where('status', 'P')
                                                    ->where('present_type', 'Half')
                                                    ->count('emp_id');
                                                $absentDay = \App\Models\Payroll\EmployeeAttendance::where('emp_id', $employee->emp_id)
                                                    ->whereBetween('date', [request()->query('start_date'), request()->query('end_date')])
                                                    ->where('status', 'A')
                                                    ->count('emp_id');
                                                $leaveDay = \App\Models\Payroll\EmployeeAttendance::where('emp_id', $employee->emp_id)
                                                    ->whereBetween('date', [request()->query('start_date'), request()->query('end_date')])
                                                    ->where('status', 'L')
                                                    ->count('emp_id');
                                            @endphp
                                            Half days leave = {{ $halfLeaveDay }}, Absent Days = {{ $absentDay }} And
                                            Leave Days = {{ $leaveDay }}
                                        </td>
                                        <td>
                                            {{ $halfLeaveDay / 2 + $absentDay + $leaveDay }}
                                        </td>
                                        <td>
                                            @php
                                                 $lateMinutes = \App\Models\Payroll\EmployeeAttendance::where('emp_id', $employee->emp_id)
                                                    ->whereBetween('date', [request()->query('start_date'), request()->query('end_date')])
                                                    ->whereNotNull('late_minute')->get();
                                            @endphp
                                            @foreach ($lateMinutes as $item)
                                                Late minutes ={{$item->late_minute}}
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
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
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script>
        let listUrl = "{{ route('payroll.attendance.list') }}";
        let editUrl = "{{ route('payroll.attendance.edit') }}";
        let updateUrl = "{{ route('payroll.attendance.update') }}";
        let storeUrl = "{{ route('payroll.attendance.store') }}";
        let token = "{{ csrf_token() }}";

        $(document).ready(function() {

            $('#employeeTable').DataTable({
                dom: 'Bfrtip',
                lengthMenu: [
                    [25, 50, 100, -1],
                    ['25 rows', '50 rows', '100 rows', 'Show all']
                ],
                buttons: [
                    'pageLength',
                    // 'print',
                    // 'excelHtml5',
                    // 'pdfHtml5',
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis',

                ],
            });

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
        })
    </script>

    {{-- <script src="{{ asset('js/backend/payroll/attendance_index.js') }}"></script> --}}
@stop
