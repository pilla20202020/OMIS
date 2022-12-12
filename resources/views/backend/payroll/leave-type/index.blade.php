@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">All Leave Types List</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">leave-type</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            @if (in_array('payroll.leave-type.create', $permissions) && auth()->user()->company_id)
                <button style="float: right" type="button" class="btn btn-primary" id="createModal">
                    + Leave Types
                </button>
            @endif
        </section>

        <!-- Main content -->
        <section class="content" style="margin-top: 35px;">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="leave-typeTable" class="table order-column hover companyTable" style="width:100%">
                        <thead>
                            <tr class="bg-grey">
                                <th>S.N.</th>
                                <th>Leave Type</th>
                                <th>Days</th>
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


    <!-- /.modal start for Add leave-type-->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Leave Type</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0rem">
                    <form action="#" method="post" id="modalForm">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="leave_type">Leave Type</label>
                                <input type="text" class="form-control" id="leave_type" name="leave_type"
                                    placeholder="Enter Leave Type">
                                <label id="leave_type-error" class="error" for="leave_type"></label>
                            </div>
                            <div class="form-group">
                                <label for="leave_type">Leave Days</label>
                                <input type="text" class="form-control" id="days" name="days"
                                    placeholder="Enter Leave Days">
                                <label id="days-error" class="error" for="days"></label>
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
        let listUrl = "{{ route('payroll.leave-type.list') }}";
        let editUrl = "{{ route('payroll.leave-type.edit') }}";
        let updateUrl = "{{ route('payroll.leave-type.update') }}";
        let storeUrl = "{{ route('payroll.leave-type.store') }}";
        let token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/backend/payroll/leave_type_index.js') }}"></script>
@stop
