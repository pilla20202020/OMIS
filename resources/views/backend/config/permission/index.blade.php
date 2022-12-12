@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">All Permissions List</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('config.dashboard.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Permissions</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
            <button style="float: right" type="button" class="btn btn-primary" id="addPermission">
                + Permission
            </button>
        </section>

        <!-- Main content -->
        <section class="content" style="margin-top: 35px;">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="dataTable" class="table order-column hover companyTable" style="width:100%">
                        <thead>
                            <tr class="bg-grey">
                                <th>SN. Number</th>
                                <th>Permission Name</th>
                                <th>showing Name</th>
                                <th>Guard Name</th>
                                <th>Group Name</th>
                                <th>Feature Name</th>
                                <th>Description</th>
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

    <!-- /.modal start-->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add|Edit Permission</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0rem">
                    <form action="#" method="post" id="modelForm">
                        @csrf
                        <input type="hidden" name="permission_id" id="permission_id">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Permission Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Permission Name">
                            </div>
                            <div class="form-group">
                                <label for="showing_name">Showing Permission Name</label>
                                <input type="text" class="form-control" id="showing_name" name="showing_name"
                                    placeholder="Enter showing Permission Name">
                            </div>
                            <div class="form-group">
                                <label for="guard_name">Guard Name</label>
                                <select class="form-control" name="guard_name" id="guard_name">
                                    <option value="WEB">WEB</option>
                                    <option value="API">API</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="group_name">Group Name</label>
                                <input type="text" class="form-control" id="group_name" name="group_name"
                                    placeholder="Enter Group Name">
                            </div>

                            {{-- <div class="form-group">
                                <label>Is Default Permission</label>
                                <select class="form-control" name="is_default" id="is_default">
                                    <option value="0">NO</option>
                                    <option value="1">YES</option>
                                </select>
                            </div> --}}

                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" name="description"
                                    placeholder="Enter Permission Description">
                            </div>

                            <div class="form-group">
                                <label>Select Feature Name</label>
                                <select class="form-control" name="feature_id" id="feature_id">
                                    @foreach ($features as $feature)
                                        <option value="{{ $feature->feature_id }}">{{ $feature->feature_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal -->

@endsection

@section('css')

    <style>

    </style>
@stop

@section('js')
    <script>
        let requestUrl = "{{ route('config.permission.list') }}";
        let getEditUrl = "{{ route('config.permission.edit') }}";
        let storeUrl = "{{ route('config.permission.store') }}";
        let token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/backend/config/permission_index.js') }}"></script>
@stop
