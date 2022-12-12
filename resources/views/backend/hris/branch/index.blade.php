@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">All Branch List</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('config.dashboard.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Branch</li>
                        </ol>
                    </div>
                </div>
            </div>
            {{-- Custom Search Filter For SUPER ADMIN --}}
            @if (auth()->user()->user_type == 'SUPER ADMIN' && !auth()->user()->company_id)
                <form action="#" id="searchForm">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-3">
                                <label>Select company</label>
                                <select class="form-control" name="company_id" id="company_id">
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value={{ $company->company_id }}>{{ $company->company_name }}</option>
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
            @if (in_array('hris.branch.create', $permissions) && auth()->user()->company_id)
                <button style="float: right" type="button" class="btn btn-primary" id="createModal">
                    + Branch
                </button>
            @endif
        </section>

        <!-- Main content -->
        <section class="content" style="margin-top: 35px;">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="branchTable" class="table order-column hover companyTable" style="width:100%">
                        <thead>
                            <tr class="bg-grey">
                                <th>S.N.</th>
                                <th>branch Name</th>
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


    <!-- /.modal start for Add branch-->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Branch</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0rem">
                    <form action="#" method="post" id="modalForm">
                        @csrf
                        <input type="hidden" name="branch_id" id="branch_id">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="branch_name">Branch Name</label>
                                <input type="text" class="form-control" id="branch_name" name="branch_name"
                                    placeholder="Enter branch Name">
                                <label id="branch_name-error" class="error" for="branch_name"></label>
                            </div>

                            <div class="form-group">
                                <label>Branch Type</label>
                                <select class="form-control" name="branch_type" id="branch_type">
                                    <option value="Branch">Branch</option>
                                    <option value="Main">Main</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="contact_number">Phone Number</label>
                                <input type="text" class="form-control" id="contact_number" name="contact_number"
                                    placeholder="Enter Branch Phone Number">
                            </div>
                            <div class="form-group">
                                <label for="mobile_number">Mobile Number</label>
                                <input type="number" class="form-control" id="mobile_number" name="mobile_number"
                                    placeholder="Enter Branch Mobile Number">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Branch Address">
                            </div>
                            <div class="form-group">
                                <label>Select Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option>Active</option>
                                    <option>Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary float-right" id="branchSubmitButton">Submit</button>
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
        let listUrl = "{{ route('hris.branch.list') }}";
        let editUrl = "{{ route('hris.branch.edit') }}";
        let updateUrl = "{{ route('hris.branch.update') }}";
        let storeUrl = "{{ route('hris.branch.store') }}";
        let token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/backend/hris/branch_index.js') }}"></script>
@stop
