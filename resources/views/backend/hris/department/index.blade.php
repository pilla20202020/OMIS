@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">All Department List</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('config.dashboard.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Department</li>
                        </ol>
                    </div>
                </div>
            </div>

            {{-- Custom Search Filter For SUPER ADMIN --}}
            @if ((auth()->user()->user_type == 'SUPER ADMIN' && !auth()->user()->company_id) || (auth()->user()->company_id && !auth()->user()->branch_id))
                <form action="#" id="searchForm">
                    <div class="card-body">
                        <div class="row">
                            @if (auth()->user()->user_type == 'SUPER ADMIN' && !auth()->user()->company_id)

                                <div class="form-group col-sm-3">
                                    <label>Select company</label>
                                    <select class="form-control" name="company_id" id="company_id">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value={{ $company->company_id }}>{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="form-group col-sm-3">
                                <label>Select Branch</label>
                                <select class="form-control" name="branch_id" id="branch_id">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value={{ $branch->branch_id }}>{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-4" style="margin-top: 32px;">
                                <button type="button" class="btn btn-primary" value="Clear" id="btnclear">clear</button>
                                <button type="button" class="btn btn-primary" value="Clear" id="btnsearch">search</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </form>
            @endif
            <!-- /.container-fluid -->
            @if (in_array('hris.department.create', $permissions) && auth()->user()->branch_id)
                <button style="float: right" type="button" class="btn btn-primary" id="createModal">
                    + Department
                </button>
            @endif
        </section>

        <!-- Main content -->
        <section class="content" style="margin-top: 35px;">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="departmentTable" class="table order-column hover companyTable" style="width:100%">
                        <thead>
                            <tr class="bg-grey">
                                <th>S.N.</th>
                                <th>Department Name</th>
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


    <!-- /.modal start for Add Department-->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Department</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0rem">
                    <form action="#" method="post" id="modalForm">
                        @csrf
                        <input type="hidden" name="dept_id" id="dept_id">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="department_name">Department Name</label>
                                <input type="text" class="form-control" id="department_name" name="department_name"
                                    placeholder="Enter Department Name">
                                <label id="department_name-error" class="error" for="department_name"></label>

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

    <style>

    </style>
@stop

@section('js')
    <script>
        let listUrl = "{{ route('hris.department.list') }}";
        let editUrl = "{{ route('hris.department.edit') }}";
        let updateUrl = "{{ route('hris.department.update') }}";
        let storeUrl = "{{ route('hris.department.store') }}";
        let token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/backend/hris/department_index.js') }}"></script>
@stop
