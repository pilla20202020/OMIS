@php
    $genders = ['Male', 'Female', 'Other'];
    $isLogin = ['NO', 'YES'];
@endphp
@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="container-fluid">

                <!-- general form elements -->
                <h4>Create OR Edit Employee</h4>

                <!-- form start -->
                <form method="post" action="{{ route('hris.employee.store') }}" id="modalForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    placeholder="Enter First Name"
                                    value="{{ old('first_name', $employee['first_name'] ?? '') }}">
                                <label id="first_name-error" class="error" for="first_name"></label>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    placeholder="Enter Last Name"
                                    value="{{ old('last_name', $employee['last_name'] ?? '') }}">
                                <label id="last_name-error" class="error" for="last_name"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email" value="{{ old('email', $employee['email'] ?? '') }}">
                                <label id="email-error" class="error" for="email"></label>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobile">Mobile Number</label>
                                <input type="number" class="form-control" id="mobile" name="mobile"
                                    placeholder="Enter Mobile Number"
                                    value="{{ old('mobile', $employee['mobile'] ?? '') }}">
                                <label id="mobile-error" class="error" for="mobile"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Address" value="{{ old('address', $employee['address'] ?? '') }}">
                                <label id="address-error" class="error" for="address"></label>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Select Gender</label>
                                <select class="form-control" name="gender" id="gender">
                                    @foreach ($genders as $item)
                                        <option value="{{ $item }}"
                                            {{ old('gender', isset($employee['gender']) && $employee['gender'] == $item ? 'selected' : '') }}>
                                            {{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Date Of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob"
                                    placeholder="Date Of Birth" value="{{ old('dob', $employee['dob'] ?? '') }}">
                                <label id="dob-error" class="error" for="dob"></label>
                            </div>
                            {{-- <div class="form-group col-md-6">
                                <label>Date Of Birth In Nepali</label>
                                <input type="text" class="form-control" id="dob_nepali" name="dob_nepali"
                                    placeholder="dd-mm-yyyy">
                                <label id="dob_nepali-error" class="error" for="dob_nepali"></label>
                            </div> --}}
                            <div class="form-group col-md-6">
                                <label>Date Of Joining</label>
                                <input type="date" class="form-control" id="doj" name="doj"
                                    placeholder="Enter Date Of Joining" value="{{ old('doj', $employee['doj'] ?? '') }}">
                                <label id="doj-error" class="error" for="doj"></label>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label>Basic Salary</label>
                                <input type="number" class="form-control" id="basic_salary" name="basic_salary"
                                    placeholder="Enter Basic Salary"
                                    value="{{ old('basic_salary', $employee['basic_salary'] ?? '0.0') }}">
                                <label id="basic_salary-error" class="error" for="basic_salary"></label>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Travelling</label>
                                <input type="number" class="form-control" id="travelling" name="travelling"
                                    placeholder="Travelling"
                                    value="{{ old('travelling', $employee['travelling'] ?? '0.0') }}">
                                <label id="travelling-error" class="error" for="travelling"></label>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Allowance</label>
                                <input type="number" class="form-control" id="allowance" name="allowance"
                                    placeholder="Allowance"
                                    value="{{ old('allowance', $employee['allowance'] ?? '0.0') }}">
                                <label id="allowance-error" class="error" for="allowance"></label>
                            </div>
                        </div>

                        <h6>Check The Benefit Schemes</h6>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" value="1" id="is_CIT"
                                        name="is_CIT"
                                        {{ isset($employee['is_CIT']) && $employee['is_CIT'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_CIT">CIT</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" value="1" id="is_SSF"
                                        name="is_SSF"
                                        {{ isset($employee['is_SSF']) && $employee['is_SSF'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_SSF">SSF</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" value="1" id="is_EPF"
                                        name="is_EPF"
                                        {{ isset($employee['is_EPF']) && $employee['is_EPF'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_EPF">EPF</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4" id="CIT_Amount"
                                style="visibility: {{ isset($employee['is_CIT']) && $employee['is_CIT'] == 1 ? 'visible' : 'hidden' }};">
                                <input type="number" class="form-control" id="CIT" name="CIT"
                                    placeholder="Enter CIT Amount" value="0.0">
                                <label id="CIT-error" class="error" for="CIT"></label>
                            </div>
                            <div class="form-group col-md-4" id="SSF_Amount"
                                style="visibility: {{ isset($employee['is_SSF']) && $employee['is_SSF'] == 1 ? 'visible' : 'hidden' }};">
                                <input type="number" class="form-control" id="SSF" name="SSF"
                                    placeholder="Enter SSF Amount" value="0.0">
                                <label id="SSF-error" class="error" for="SSF"></label>
                            </div>
                            <div class="form-group col-md-4" id="EPF_Amount"
                                style="visibility: {{ isset($employee['is_EPF']) && $employee['is_EPF'] == 1 ? 'visible' : 'hidden' }};">
                                <input type="number" class="form-control" id="EPF" name="EPF"
                                    placeholder="Enter EPF Amount" value="0.0">
                                <label id="EPF-error" class="error" for="EPF"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Department</label>
                                <select class="form-control" name="dept_id" id="dept_id">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $item)
                                        <option value="{{ $item->dept_id }}"
                                            {{ isset($employee['dept_id']) && $employee['dept_id'] == $item->dept_id ? 'selected' : '' }}>
                                            {{ $item->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label id="dept_id-error" class="error" for="dept_id"></label>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Designation</label>
                                <select class="form-control" name="designation_id" id="designation_id">
                                    <option value="">Select Designation</option>
                                    @foreach ($designations as $item)
                                        <option value="{{ $item->designation_id }}"
                                            {{ isset($employee['designation_id']) && $employee['designation_id'] == $item->designation_id ? 'selected' : '' }}>
                                            {{ $item->designation_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label id="designation_id-error" class="error" for="designation_id"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Shift Time</label>
                                <select class="form-control" name="shift_id" id="shift_id">
                                    @foreach ($shifts as $item)
                                        <option value="{{ $item->shift_id }}"
                                            {{ isset($employee['shift_id']) && $employee['shift_id'] == $item->shift_id ? 'selected' : '' }}>
                                            {{ $item->shift_type }}
                                        </option>
                                    @endforeach
                                </select>
                                <label id="shift_id-error" class="error" for="shift_id"></label>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Assign Login Credentials To Employee?</label>
                                <select class="form-control" name="is_login" id="is_login"
                                    {{ isset($employee['is_login']) && $employee['is_login'] == 'YES' ? 'disabled' : '' }}>
                                    @foreach ($isLogin as $item)
                                        <option
                                            {{ isset($employee['is_login']) && $employee['is_login'] == $item ? 'selected' : '' }}>
                                            {{ $item }}</option>
                                    @endforeach
                                </select>
                                <label id="is_login-error" class="error" for="is_login"></label>
                            </div>
                        </div>
                        @if (!isset($employee['is_login']) || $employee['is_login'] == 'NO')
                            <div class="row d-none isLogin">
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter Password">
                                    <label id="password-error" class="error" for="password"></label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation">Confirmed Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Enter Confirmed Password">
                                </div>
                            </div>
                            <div class="row d-none isLogin">
                                <div class="form-group col-md-6">
                                    <label>Select Role</label>
                                    <select class="form-control" name="role_id" id="role_id">
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->role_id }}">{{ $item->role_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label id="role_id-error" class="error" for="role_id"></label>
                                </div>
                            </div>
                        @endif

                        @if (isset($employee['is_login']) && $employee['is_login'] == 'YES')
                        <div class="row  isLogin">
                            <div class="form-group col-md-6">
                                <label>Select Role</label>
                                <select class="form-control" name="role_id" id="role_id">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->role_id }}" {{isset($userRole) && $userRole->role_id == $item->role_id ? 'selected':'' }}>{{ $item->role_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label id="role_id-error" class="error" for="role_id"></label>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </section>

    </div>


    <!-- /.modal start for Add Feature-->
    {{-- <div class="modal fade" id="modal-add">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0rem">
                    <form action="#" method="post" id="modalForm">
                        @csrf
                        <input type="hidden" name="employee_id" id="employee_id">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        placeholder="Enter First Name">
                                    <label id="first_name-error" class="error" for="first_name"></label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        placeholder="Enter Last Name">
                                    <label id="last_name-error" class="error" for="last_name"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter Email">
                                    <label id="email-error" class="error" for="email"></label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="mobile">Mobile Number</label>
                                    <input type="number" class="form-control" id="mobile" name="mobile"
                                        placeholder="Enter Mobile Number">
                                    <label id="mobile-error" class="error" for="mobile"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Enter Address">
                                    <label id="address-error" class="error" for="address"></label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Select Gender</label>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Date Of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob"
                                        placeholder="Date Of Birth">
                                    <label id="dob-error" class="error" for="dob"></label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Date Of Birth In Nepali</label>
                                    <input type="text" class="form-control" id="dob_nepali" name="dob_nepali"
                                        placeholder="dd-mm-yyyy">
                                    <label id="dob_nepali-error" class="error" for="dob_nepali"></label>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Date Of Joining</label>
                                    <input type="date" class="form-control" id="doj" name="doj"
                                        placeholder="Enter Date Of Joining">
                                    <label id="doj-error" class="error" for="doj"></label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Basic Salary</label>
                                    <input type="number" class="form-control" id="basic_salary" name="basic_salary"
                                        placeholder="Enter Basic Salary" value="0.0">
                                    <label id="basic_salary-error" class="error" for="basic_salary"></label>
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label>Travelling</label>
                                    <input type="number" class="form-control" id="travelling" name="travelling"
                                        placeholder="Travelling" value="0.0">
                                    <label id="travelling-error" class="error" for="travelling"></label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Allowance</label>
                                    <input type="number" class="form-control" id="allowance" name="allowance"
                                        placeholder="Allowance" value="0.0">
                                    <label id="allowance-error" class="error" for="allowance"></label>
                                </div>
                            </div>
                            <h6>Check The Benefit Schemes</h6>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" value="1" id="is_CIT"
                                            name="is_CIT">
                                        <label class="form-check-label" for="is_CIT">CIT</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" value="1" id="is_SSF"
                                            name="is_SSF">
                                        <label class="form-check-label" for="is_SSF">SSF</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" value="1" id="is_EPF"
                                            name="is_EPF">
                                        <label class="form-check-label" for="is_EPF">EPF</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4" id="CIT_Amount" style="visibility: hidden;">
                                    <input type="number" class="form-control" id="CIT" name="CIT"
                                        placeholder="Enter CIT Amount" value="0.0">
                                    <label id="CIT-error" class="error" for="CIT"></label>
                                </div>
                                <div class="form-group col-md-4" id="SSF_Amount" style="visibility: hidden;">
                                    <input type="number" class="form-control" id="SSF" name="SSF"
                                        placeholder="Enter SSF Amount" value="0.0">
                                    <label id="SSF-error" class="error" for="SSF"></label>
                                </div>
                                <div class="form-group col-md-4" id="EPF_Amount" style="visibility: hidden;">
                                    <input type="number" class="form-control" id="EPF" name="EPF"
                                        placeholder="Enter EPF Amount" value="0.0">
                                    <label id="EPF-error" class="error" for="EPF"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Department</label>
                                    <select class="form-control" name="dept_id" id="dept_id">
                                        @foreach ($departments as $item)
                                            <option value="{{ $item->dept_id }}">{{ $item->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label id="dept_id-error" class="error" for="dept_id"></label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Designation</label>
                                    <select class="form-control" name="designation_id" id="designation_id">
                                        @foreach ($designations as $item)
                                            <option value="{{ $item->designation_id }}">{{ $item->designation_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label id="designation_id-error" class="error" for="designation_id"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Shift Time</label>
                                    <select class="form-control" name="shift_id" id="shift_id">
                                        @foreach ($shifts as $item)
                                            <option value="{{ $item->shift_id }}">{{ $item->shift_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label id="shift_id-error" class="error" for="shift_id"></label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Assign Login Credentials To Employee?</label>
                                    <select class="form-control" name="is_login" id="is_login">
                                        <option>NO</option>
                                        <option>YES</option>
                                    </select>
                                    <label id="is_login-error" class="error" for="is_login"></label>
                                </div>
                            </div>
                            <div class="row d-none isLogin">
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter Password">
                                    <label id="password-error" class="error" for="password"></label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation">Confirmed Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Enter Confirmed Password">
                                </div>
                            </div>
                            <div class="row d-none isLogin">
                                <div class="form-group col-md-6">
                                    <label>Select Role</label>
                                    <select class="form-control" name="role_id" id="role_id">
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->role_id }}">{{ $item->role_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label id="role_id-error" class="error" for="role_id"></label>
                                </div>
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
    </div> --}}
    <!-- /.modal End -->




@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <style>
        /* .form-group {
                        margin-bottom: 0rem;
                    } */
    </style>
@stop

@section('js')
    <script>
        let listUrl = "{{ route('hris.employee.list') }}";
        let editUrl = "{{ route('hris.employee.edit') }}";
        let updateUrl = "{{ route('hris.employee.update') }}";
        let storeUrl = "{{ route('hris.employee.store') }}";
        let designationByDeptId = "{{route('hris.designation.by-deptid')}}";
        let token = "{{ csrf_token() }}";
    </script>

    <script src="{{ asset('js/backend/hris/employee_index.js') }}"></script>
    <script src="{{ asset('js/backend/common_js.js') }}"></script>
@stop
