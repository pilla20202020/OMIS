@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">All Designation List</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Designation</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            @if (in_array('hris.designation.create', $permissions) && auth()->user()->company_id)
                <button style="float: right" type="button" class="btn btn-primary" id="createModal">
                    + Designation
                </button>
            @endif
        </section>

        <!-- Main content -->
        <section class="content" style="margin-top: 35px;">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="designationTable" class="table order-column hover companyTable" style="width:100%">
                        <thead>
                            <tr class="bg-grey">
                                <th>S.N.</th>
                                <th>Department Name</th>
                                <th>Designation Name</th>
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


    <!-- /.modal start for Add Designation-->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Designation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0rem">
                    <form action="#" method="post" id="modalForm">
                        @csrf
                        <input type="hidden" name="designation_id" id="designation_id">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Select Department</label>
                                <select class="form-control" name="dept_id" id="dept_id">
                                    @foreach ($departments as $item)
                                    <option value="{{$item->dept_id}}">{{$item->department_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="designation_name">Designation Name</label>
                                <input type="text" class="form-control" id="designation_name" name="designation_name"
                                    placeholder="Enter Designation Name">
                                <label id="designation_name-error" class="error" for="designation_name"></label>

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
        let listUrl = "{{ route('hris.designation.list') }}";
        let editUrl = "{{ route('hris.designation.edit') }}";
        let updateUrl = "{{ route('hris.designation.update') }}";
        let storeUrl = "{{ route('hris.designation.store') }}";
        let token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/backend/hris/designation_index.js') }}"></script>
@stop
