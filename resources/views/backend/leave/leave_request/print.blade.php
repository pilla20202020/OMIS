@extends('backend.layouts.master')

@section('title', 'Absent Request')

@section('content')
 <!-- start page title -->
 <div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Invoice</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Absent Request</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-md-12 col-lg-10 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <img src="assets/images/logo-sm-dark.png" alt="" class="img-fluid" width="75">
                    </div>

                    <div class="col-lg-6  align-self-center">
                        <div class="">
                            <div class="float-right">
                                <h6 class="mb-0"><b>Request Date :</b> {{$absentrequest->date}}</h6>
                            </div>
                        </div>
                    </div>
                </div>



                <hr>
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-12 col-xl-4 ml-auto align-self-center">
                        <div class="text-center text-muted"><small>Thank you very much for doing business with us. Thanks !</small></div>
                    </div>
                    <div class="col-lg-12 col-xl-4">
                        <div class="float-right d-print-none">
                            <a href="javascript:window.print()" class="btn btn-info"><i class="fa fa-print"></i></a>
                            <a href="{{route('leaverequest.index')}}" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


