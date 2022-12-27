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
                <form action="{{route('leaverequest.particularmonth')}}" type="POST">
                    @csrf
                    <div class="row">
                        <div class="col-4">

                            <select name="year" id="" class="form-control" required>
                                <option disabled value="" selected>  -- Please Select Year --  </option>
                                @foreach ($years as $data)
                                    <option value="{{$data->year}}" @if(isset($current_year) && ($current_year == $data->year))  selected  @endif>{{$data->year}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <select name="month" id="" class="form-control">
                                <option disabled selected>  -- Please Select Month --  </option>
                                <option value="1" @if($month == 1) selected @endif>January</option>
                                <option value="2" @if($month == 2) selected @endif>February</option>
                                <option value="3" @if($month == 3) selected @endif>March</option>
                                <option value="4" @if($month == 4) selected @endif>April</option>
                                <option value="5" @if($month == 5) selected @endif>May</option>
                                <option value="6" @if($month == 6) selected @endif>June</option>
                                <option value="7" @if($month == 7) selected @endif>July</option>
                                <option value="8" @if($month == 8) selected @endif>August</option>
                                <option value="9" @if($month == 9) selected @endif>September</option>
                                <option value="10" @if($month == 10) selected @endif>October</option>
                                <option value="11" @if($month == 11) selected @endif>November</option>
                                <option value="12" @if($month == 12) selected @endif>December</option>
                            </select>
                        </div>

                        <div class="col-4 mt-1">
                            <button type="submit" class="btn btn-success">Search</button>
                        </div>
                    </div>

                </form>
                <table id="datatable" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Request Name</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Absent Type</th>
                        <th>Type</th>
                        <th>Sub Total</th>
                        <th>Approved By</th>
                        <th>Actions</th>
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
                "ajax": '{{ route('leaverequest.getreportbymonth',[$month,$current_year]) }}',
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
                    { "data": "DT_RowIndex",  orderable: false, searchable: false },
                    { "data": "request_name" },
                    { "data": "from"},
                    { "data": "to"},
                    { "data": "absent_type"},
                    { "data": "type"},
                    { "data": "sub_total"},
                    { "data": "status_user"},
                    { "data": "actions", orderable: false, searchable: false },
                ],
                order: [ [0, 'desc'] ]
            });
        } );
    </script>
@endsection


