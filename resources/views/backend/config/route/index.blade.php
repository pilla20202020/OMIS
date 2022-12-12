@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">All Routes List</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('config.dashboard.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Routes details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
            <button style="float: right" type="button" class="btn btn-primary" data-toggle="modal"
                data-target="#modal-add">
                + Route Permission
            </button>
        </section>

        <!-- Main content -->
        <section class="content" style="margin-top: 35px;">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="companyTable" class="table order-column hover companyTable" style="width:100%">
                        <thead>
                            <tr class="bg-grey">
                                <th>SN. Number</th>
                                <th>Route Name(Permission)</th>
                                <th>Show Route(Permission) Name</th>
                                <th>Route Path</th>
                                <th>Method Name</th>
                                <th>Method Type</th>
                                <th>Controller Name</th>
                                <th>Group Name</th>
                                <th>Feature Name</th>
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
                    <h4 class="modal-title">Add|Edit Route Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0rem">
                    <form action="{{route('config.route.store')}}" method="post" id="routeForm">
                        @csrf
                        <input type="hidden" name="route_id" id="route_id">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="route_name">Route Name</label>
                                <input type="text" class="form-control" id="route_name" name="route_name"
                                    placeholder="Enter route name for permission">
                            </div>
                            <div class="form-group">
                                <label for="show_route_name">Showing Route Name</label>
                                <input type="text" class="form-control" id="show_route_name" name="show_route_name"
                                    placeholder="Enter showing Route Name">
                            </div>
                            <div class="form-group">
                                <label for="route_path">Route Path</label>
                                <input type="text" class="form-control" id="route_path" name="route_path"
                                    placeholder="Enter Route Path">
                            </div>

                            <div class="form-group">
                                <label for="method_name">Route Method Name</label>
                                <input type="text" class="form-control" id="method_name" name="method_name"
                                    placeholder="Enter Route Method Name">
                            </div>
                            
                            <div class="form-group">
                                <label>Select Route Method Type</label>
                                <select class="form-control" name="method_type" id="method_type">
                                    <option value="get">get</option>
                                    <option value="post">post</option>
                                    <option value="put">put</option>
                                    <option value="delete">delete</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="controller_name">Controller Name</label>
                                <input type="text" class="form-control" id="controller_name" name="controller_name"
                                    value="App\Http\Controllers\">
                            </div>
                            <div class="form-group">
                                <label for="group_name">Group Name</label>
                                <input type="text" class="form-control" id="group_name" name="group_name"
                                    placeholder="Enter Group Name">
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
        let routeDataUrl = "{{ route('config.route.list') }}";
        let getEditUrl = "{{ route('config.route.get.edit.ajax') }}";
        let token = "{{ csrf_token() }}";   
    </script>
    <script src="{{ asset('js/backend/config/route_details_index.js') }}"></script>
@stop
