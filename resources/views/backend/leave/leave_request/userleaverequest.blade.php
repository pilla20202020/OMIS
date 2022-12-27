@extends('backend.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/TableTools.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}"/>
@endsection

@section('title', 'View All Leave Request   ')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex">
                <header class="text-capitalize pt-1">My Leave Requests</header>
                <div class="tools ml-auto">
                    <a class="btn btn-primary ink-reaction" href="{{ route('leaverequest.create') }}">
                        <i class="fa fa-plus"></i>
                        Add
                    </a>
                </div>
            </div>
            <div class="card mt-4 p-4">
                <table id="datatable" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Request By</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Leave Type</th>
                        <th>Half/Full</th>
                        <th>Total Days</th>
                        <th>Status</th>
                        <th>Approved By</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('leaverequest.userdata') }}',
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print',
                //     // exportOptions: {
                //     //     columns: 'th:not(:last-child)'
                //     // }
                // ],
                dom: 'Bfrtip',
                buttons: [

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
        } );
    </script>
@endsection


