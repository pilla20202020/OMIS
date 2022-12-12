@extends('backend.layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="card-title">All employee List</h3>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Campaign</li>
                    </ol>
                </div>
            </div>
        </div>
        <a href="{{ route('lms.campaign.create') }}" style="float: right" type="button" class="btn btn-primary">
            + Campaign
        </a>
    </section>


    <!-- Main content -->
    <section class="content" style="margin-top: 35px;">
        <div class="container-fluid">
            <div class="table-responsive">
                <table id="employeeTable" class="table order-column hover companyTable" style="width:100%">
                    <thead>
                        <tr class="bg-grey">
                            <th>SN</th>
                            <th>Name</th>
                            <th>Banner</th>
                            <th>Detail</th>
                            <th>Starts</th>
                            <th>End</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @each('backend.lms.campaign.partials.table', $campaigns, 'campaign')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
