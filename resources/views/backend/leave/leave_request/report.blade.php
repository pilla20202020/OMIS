@extends('backend.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/TableTools.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}"/>
@endsection

@section('title', 'Report List')

@section('content')
<div class="content-wrapper">

    <div class="row">
        <div class="col-12">
            <div class="card mt-4 p-4">
                <table id="datatable" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>User Name</th>
                        <th>Remaining Annual Leave Days</th>
                        <th>Remaining Sick Leave Days</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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
            $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('leaverequest.getreport') }}',
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print',
                //     // exportOptions: {
                //     //     columns: 'th:not(:last-child)'
                //     // }
                // ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Export Search Results',
                        className: 'btn btn-default',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    }
                ],
                "columns": [
                    { "data": "DT_RowIndex",  orderable: false, searchable: false },
                    { "data": "name" },
                    { "data": "remain_annual_leave",searchable: false},
                    { "data": "remain_sick_leave",searchable: false },
                ],
                order: [ [0, 'desc'] ]
            });
        } );
    </script>
@endsection


