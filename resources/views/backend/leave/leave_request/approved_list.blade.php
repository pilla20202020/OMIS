@extends('backend.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/TableTools.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}"/>
@endsection

@section('title', 'Leave Requests')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="d-flex">
                <header class="text-capitalize pt-1">Leave Requests</header>
            </div>
            <div class="card mt-4 p-4">
                <table id="datatable" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Requested By</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Leave Type</th>
                        <th>Full/Half</th>
                        <th>Total Days</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title align-self-center mt-0 text-center" id="exampleModalLabel">User Leave History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>S.No.</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Leave Type</th>
                                <th>Type</th>
                                <th>Total no. of Days</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="userleavehistory">

                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
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
                "ajax": '{{ route('leaverequest.requesttobeapproved') }}',
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
                    { "data": "user_id" },
                    { "data": "start_date" },
                    { "data": "end_date" },
                    { "data": "leave_type" },
                    { "data": "type" },
                    { "data": "sub_total" },
                    { "data": "actions", orderable: false, searchable: false },
                ],
                order: [ [0, 'desc'] ]
            });



        });

        function approvedthis(id) {
                var approved_id = JSON.parse(id);
                $.ajax({
                    type: 'get',
                    url: '{{route('leaverequest.tobeapprove')}}',
                    data: {
                        approved_id: approved_id,
                    },
                    success:function(response){
                    if(typeof(response) != 'object'){
                        response = JSON.parse(response)
                    }
                    if(response.status){
                        $('#datatable').DataTable().ajax.reload();
                    }
                }

                })
            }

            function rejectthis(id) {
                var rejected_id = JSON.parse(id);
                $.ajax({
                    type: 'get',
                    url: '{{route('leaverequest.tobereject')}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        rejected_id: rejected_id,
                    },
                    success:function(response){
                    if(typeof(response) != 'object'){
                        response = JSON.parse(response)
                    }
                    if(response.status){
                        $('#datatable').DataTable().ajax.reload();
                    }
                }

                })
            }

            $(document).on('click','.viewhistory',function (e) {
                let user_id = $(this).data('user_id');
                $.ajax({
                    type: 'get',
                    url: '{{route('leaverequest.getuserdetail')}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        user_id: user_id,
                    },
                    success:function(response){
                    if(typeof(response) != 'object'){
                        response = JSON.parse(response)
                    }
                    var tbody_html = "";
                    if(response.status){
                        $.each(response.data, function(key, leave_detail){
                            key = key+1;
                            tbody_html += "<tr>";
                            tbody_html += "<td>"+key+"</td>";
                            tbody_html += "<td>"+leave_detail.start_date+"</td>";
                            tbody_html += "<td>"+leave_detail.end_date+"</td>";
                            if(leave_detail.leave_type == 1) {
                                tbody_html += "<td>AnnualLeave</td>";
                            } else {
                                tbody_html += "<td>SickLeave</td>";
                            }
                            tbody_html += "<td>"+leave_detail.type+"</td>";
                            tbody_html += "<td>"+leave_detail.sub_total+" Days</td>";
                            if(leave_detail.status == 1){
                                tbody_html += "<td><span class='badge badge-primary'>Approved</span></td>";
                            }else if(leave_detail.status == 0) {
                                tbody_html += "<td><span class='badge badge-danger'>Rejected</span></td>";
                            }
                            else {
                                tbody_html += "<td><span class='badge badge-warning'>Pending</span></td>";
                            }
                            tbody_html += "</tr>";
                        });
                        $('#userleavehistory').html(tbody_html);
                        $('.bs-example-modal-center').modal('show');
                    }
                }

                })
            });



    </script>
@endsection


