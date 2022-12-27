@extends('backend.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/TableTools.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}"/>
@endsection

@section('title', 'View All Leave Request')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="d-flex">
                <header class="text-capitalize pt-1">All Leave Request</header>
                <div class="tools ml-auto">
                    <a class="btn btn-primary ink-reaction" href="{{ route('leaverequest.create') }}">
                        <i class="fa fa-plus"></i>

                        Add
                    </a>
                </div>
            </div>
            <div class="card mt-4 p-4">
                <div>
                    <div class="col-lg-5">
                        <ul class="nav nav-pills nav-justified" role="tablist">
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link" data-toggle="tab" href="#tab-table0" data-type="1" role="tab" >All</a>
                            </li>
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link active" data-toggle="tab" href="#tab-table1" role="tab">Pending</a>
                            </li>
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link" data-toggle="tab" href="#tab-table2" data-type="1" role="tab" >Approved</a>
                            </li>
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link" data-toggle="tab" href="#tab-table3" data-type="0" role="tab">Rejected</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane p-3" id="tab-table0 " >
                            <table id="datatable0" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Request By</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Leave Type</th>
                                    <th>Full/Half</th>
                                    <th>Total Days</th>
                                    <th>Status</th>
                                    <th>Approved By</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="tab-pane p-3 active" id="tab-table1" >
                            <table id="datatable1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Request By</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Leave Type</th>
                                        <th>Full/Half</th>
                                        <th>Total Days</th>
                                        <th>Status</th>
                                        <th>Approved By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="tab-pane p-3" id="tab-table2">
                            <table id="datatable2" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Request By</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Leave Type</th>
                                    <th>Full/Half</th>
                                    <th>Total Days</th>
                                    <th>Status</th>
                                    <th>Approved By</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane p-3" id="tab-table3">
                            <table id="datatable3" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Request User Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Leave Type</th>
                                        <th>Type</th>
                                        <th>Total no Of Days</th>
                                        <th>Status</th>
                                        <th>Approved By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script>

        $(document).ready( function () {
            $('#datatable0').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('leaverequest.data') }}',
                dom: 'Blfrtip',
                lengthMenu: [ [20, 40, 60, -1], ['20 List', '40 List', '60 List', 'All'] ],
                dom: 'Bfrtip',
                buttons:
                [
                    { extend: 'pdf', text: ' Exportar a PDF',exportOptions: {columns: 'th:not(:last-child)'} },
                    { extend: 'csv', text: ' Exportar a CSV',exportOptions: {columns: 'th:not(:last-child)'} }, 'pageLength'
                ],
                "columns": [
                    { "data": "id",  'visible': false },
                    { "data": "user_id" },
                    { "data": "start_date" },
                    { "data": "end_date" },
                    { "data": "leave_type" },
                    { "data": "type" },
                    { "data": "sub_total" },
                    { "data": "is_approved" },
                    { "data": "approved_by" },
                    { "data": "actions", orderable: false, searchable: false },
                ],
                order: [ [0, 'desc'] ]
            });
            $('#datatable1').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('leaverequest.data') }}',
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print',
                //     // exportOptions: {
                //     //     columns: 'th:not(:last-child)'
                //     // }
                // ],
                dom: 'Blfrtip',
                lengthMenu: [ [20, 40, 60, -1], ['20 List', '40 List', '60 List', 'All'] ],
                dom: 'Bfrtip',
                buttons:
                [
                    { extend: 'pdf', text: ' Exportar a PDF',exportOptions: {columns: 'th:not(:last-child)'} },
                    { extend: 'csv', text: ' Exportar a CSV',exportOptions: {columns: 'th:not(:last-child)'} }, 'pageLength'
                ],
                "columns": [
                    { "data": "id",  'visible': false },
                    { "data": "user_id" },
                    { "data": "start_date" },
                    { "data": "end_date" },
                    { "data": "leave_type" },
                    { "data": "type" },
                    { "data": "sub_total" },
                    { "data": "is_approved" },
                    { "data": "approved_by" },
                    { "data": "actions", orderable: false, searchable: false },
                ],
                order: [ [0, 'desc'] ]
            }).search('Pending').draw();
            $('#datatable2').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('leaverequest.data') }}',
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print',
                //     // exportOptions: {
                //     //     columns: 'th:not(:last-child)'
                //     // }
                // ],
                dom: 'Blfrtip',
                lengthMenu: [ [20, 40, 60, -1], ['20 List', '40 List', '60 List', 'All'] ],
                dom: 'Bfrtip',
                buttons:
                [
                    { extend: 'pdf', text: ' Exportar a PDF',exportOptions: {columns: 'th:not(:last-child)'} },
                    { extend: 'csv', text: ' Exportar a CSV',exportOptions: {columns: 'th:not(:last-child)'} }, 'pageLength'
                ],
                "columns": [
                    { "data": "id",  'visible': false },
                    { "data": "user_id" },
                    { "data": "start_date" },
                    { "data": "end_date" },
                    { "data": "leave_type" },
                    { "data": "type" },
                    { "data": "sub_total" },
                    { "data": "is_approved" },
                    { "data": "approved_by" },
                    { "data": "actions", orderable: false, searchable: false },
                ],
                order: [ [0, 'desc'] ]
            }).search('Approved').draw();
            $('#datatable3').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('leaverequest.data') }}',
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print',
                //     // exportOptions: {
                //     //     columns: 'th:not(:last-child)'
                //     // }
                // ],
                dom: 'Blfrtip',
                lengthMenu: [ [20, 40, 60, -1], ['20 List', '40 List', '60 List', 'All'] ],
                dom: 'Bfrtip',
                buttons:
                [
                    { extend: 'pdf', text: ' Exportar a PDF',exportOptions: {columns: 'th:not(:last-child)'} },
                    { extend: 'csv', text: ' Exportar a CSV',exportOptions: {columns: 'th:not(:last-child)'} }, 'pageLength'
                ],
                "columns": [
                    { "data": "id",  'visible': false },
                    { "data": "user_id" },
                    { "data": "start_date" },
                    { "data": "end_date" },
                    { "data": "leave_type" },
                    { "data": "type" },
                    { "data": "sub_total" },
                    { "data": "is_approved" },
                    { "data": "approved_by" },
                    { "data": "actions", orderable: false, searchable: false },
                ],
                order: [ [0, 'desc'] ]
            }).search('Rejected').draw();
        })

    </script>
@endsection


