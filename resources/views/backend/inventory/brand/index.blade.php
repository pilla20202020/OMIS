@extends('backend.layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="card-title">All Brand List</h3>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">brand</li>
                    </ol>
                </div>
            </div>
        </div>
        <a href="{{ route('inventory.brand.create') }}" style="float: right" type="button" class="btn btn-primary">
            + Brand
        </a>
    </section>


    <!-- Main content -->
    <section class="content" style="margin-top: 35px;">
        <div class="container-fluid">
            <div class="table-responsive">
                <table id="datatable" class="table border-0 table-striped">

                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>S.No.</th>
                        <th>Image</th>
                        <th>Brand Name</th>
                        <th>Description</th>

                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </section>
@stop

@section('js')

    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                processing: false,
                serverSide: false,
                // scrollY: '52vh',
                // scrollX: true,
                pageLength: 25,
                bFilter: true,
                bSort: true,
                "ajax": '{{ route('inventory.brand.data') }}',
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
                    { "data": "id",  'visible': false },
                    { "data": "DT_RowIndex",  orderable: false, searchable: false },
                    { "data": "image" },
                    { "data": "name" },
                    { "data": "description" },

                    { "data": "actions", orderable: false, searchable: false },
                ],
                order: [ [0, 'desc'] ]
            });
        } );
    </script>
@endsection
