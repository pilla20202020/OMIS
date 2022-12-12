@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">All Features List</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('config.dashboard.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Features</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
            @if (in_array('config.feature.create', $permissions))
                <button style="float: right" type="button" class="btn btn-primary" id="createFeature">
                    + Feature
                </button>
            @endif
        </section>

        <!-- Main content -->
        <section class="content" style="margin-top: 35px;">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="featureTable" class="table order-column hover companyTable" style="width:100%">
                        <thead>
                            <tr class="bg-grey">
                                <th>SN. Number</th>
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

    <!-- /.modal start for Add Feature-->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Feature</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0rem">
                    <form action="#" method="post" id="modelForm">
                        @csrf
                        <input type="hidden" name="feature_id" id="feature_id">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="feature_name">Feature Name</label>
                                <input type="text" class="form-control" id="feature_name" name="feature_name"
                                    placeholder="Enter Feature Name">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3"
                                    placeholder="Enter Feature Description..."></textarea>
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

                        <!-- /.card-body -->
                        {{-- <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div> --}}
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
        let requestUrl = "{{ route('config.feature.list') }}";
        let storeUrl = "{{ route('config.feature.store') }}";
        let editUrl = "{{ route('config.feature.edit') }}";
        let updateUrl = "{{ route('config.feature.update') }}";
        var token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/backend/config/feature-index.js') }}"></script>
@stop
