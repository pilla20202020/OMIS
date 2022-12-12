@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">All Companies List</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Companies</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            @if (in_array('config.company.store', $permissions))
                <button style="float: right" type="button" class="btn btn-primary" id="createModel">
                    + Company
                </button>
            @endif
        </section>

        <!-- Main content -->
        <section class="content" style="margin-top: 35px;">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="companyTable" class="table order-column hover companyTable" style="width:100%">
                        <thead>
                            <tr class="bg-grey">
                                <th>SN. Number</th>
                                <th>Company Name</th>
                                <th>Owner Name</th>
                                <th>Company Email</th>
                                <th>Company Phone</th>
                                <th>Company Mobile No.</th>
                                <th>Company Address</th>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Company</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0rem">
                    <form action="#" method="post" id="modalForm">
                        @csrf
                        <input type="hidden" name="company_id" id="company_id">
                        <div class="card-body">
                            <h5>Owner Details:</h5>
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

                            <h5>Company Details:</h5>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                        placeholder="Enter Company Name">
                                    <label id="company_name-error" class="error" for="company_name"></label>

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_email">Company Email</label>
                                    <input type="text" class="form-control" id="company_email" name="company_email"
                                        placeholder="Enter Company Name">
                                    <label id="company_email-error" class="error" for="company_email"></label>

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="company_phone">Company Phone Number</label>
                                    <input type="text" class="form-control" id="company_phone" name="company_phone"
                                        placeholder="Enter Phone Number">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_mobile">Company Mobile Number</label>
                                    <input type="text" class="form-control" id="company_mobile" name="company_mobile"
                                        placeholder="Enter Mobile Number">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Address</label>
                                    <textarea class="form-control" name="company_address" id="company_address" rows="3"
                                        placeholder="Enter Company Address..."></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Select Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option>Active</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <h5>Features:</h5>
                            @foreach ($features as $feature)
                                <div class="row">
                                    @foreach ($feature as $item)
                                        <div class="col-sm-3">
                                            <!-- checkbox -->
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="featureId[]" id="{{ $item->feature_name }}"
                                                        value="{{ $item->feature_id }}">
                                                    <label for="{{ $item->feature_name }}"
                                                        class="form-check-label">{{ $item->feature_name }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

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

    <!-- /.modal start for Edit Feature-->
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Company</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0rem">
                    <form action="#" method="post" id="editModalForm">
                        @csrf
                        <input type="hidden" name="company_id" id="company_id2">
                        <div class="card-body">
                            <h5>Company Details:</h5>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control" id="company_name2" name="company_name"
                                        placeholder="Enter Company Name">
                                    <label id="company_name-error" class="error" for="company_name"></label>

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_email">Company Email</label>
                                    <input type="text" class="form-control" id="company_email2" name="company_email"
                                        placeholder="Enter Company Name">
                                    <label id="company_email-error" class="error" for="company_email"></label>

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="company_phone">Company Phone Number</label>
                                    <input type="text" class="form-control" id="company_phone2" name="company_phone"
                                        placeholder="Enter Phone Number">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_mobile">Company Mobile Number</label>
                                    <input type="text" class="form-control" id="company_mobile2" name="company_mobile"
                                        placeholder="Enter Mobile Number">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Address</label>
                                    <textarea class="form-control" name="company_address" id="company_address2" rows="3"
                                        placeholder="Enter Company Address..."></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Select Status</label>
                                    <select class="form-control" name="status" id="status2">
                                        <option>Active</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <h5>Features:</h5>
                            @foreach ($features as $feature)
                                <div class="row">
                                    @foreach ($feature as $item)
                                        <div class="col-sm-3">
                                            <!-- checkbox -->
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="featureId[]" id="feature_{{ $item->feature_id }}"
                                                        value="{{ $item->feature_id }}">
                                                    <label for="{{ $item->feature_name }}"
                                                        class="form-check-label">{{ $item->feature_name }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

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
        let companyDataUrl = "{{ route('config.company.list') }}";
        let editUrl = "{{ route('config.company.edit') }}";
        let updateUrl = "{{ route('config.company.update') }}";
        let storeUrl = "{{ route('config.company.store') }}";
        let token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/backend/config/company_index.js') }}"></script>
@stop
