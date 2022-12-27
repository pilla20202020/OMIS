@extends('backend.layouts.master')

@section('title', 'Leave Request')

@section('content')
 <!-- start page title -->
<!-- end page title -->
{{-- <form class="form form-validate floating-label" action="{{route('leaverequest.update',$leaverequest->id)}}"
    method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf --}}
<div class="content-wrapper">
    <div class="row mt-5">
        <div class="col-md-9 col-lg-9 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 ">
                            <div class="">
                                <h6 class="mb-0"><b>Request User :</b> {{$leaverequest->user->name}}</h6>
                            </div>
                        </div>

                        <div class="col-lg-6  d-flex align-self-center">
                            <div class="ml-auto">
                                <div>
                                    <h6 class="mb-0"><b>Request Date :</b> {{$leaverequest->date}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>




                    <hr>
                    <div class="row mt-3">
                        <div class="col-lg-6 col-md-6">
                            <h6 class="pl-3 pt-4">Start Date (From) : {{$leaverequest->start_date}}</h6>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <h6 class="pl-3 pt-4">Start Date (To) : {{$leaverequest->end_date}}</h6>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <h6 class="pl-3 pt-4">Total Number Of Days : {{$leaverequest->sub_total}} Days</h6>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <h6 class="pl-3 pt-4">Description : {{$leaverequest->description}} </h6>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <h6 class="pl-3 pt-4">Leave Type(Annual / Sick) : {{$leaverequest->leavetype->name}}</h6>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <h6 class="pl-3 pt-4">Type(Fulltime / Sick) : {{$leaverequest->type}}</h6>
                        </div>

                        {{-- <div class="col-lg-12 m-2">
                            <div class="form-group d-flex mb-0" >
                                <h6 class="pl-1 pr-3">Is Approved :</h6>
                                <input type="checkbox" id="switch2" switch="none" name="is_approved" {{ old('is_approved', isset($leaverequest->is_approved) ? $leaverequest->is_approved : '')=='1' ? 'checked':'' }}/>
                                <label for="switch2" data-on-label="On" data-off-label="Off"></label>
                            </div>
                        </div> --}}

                        @if($leaverequest->approved_by)
                            <div class="col-lg-6 col-md-6">
                                <h6 class="pl-3 pt-4">Approved By: @if(isset($leaverequest->approved_by) && !empty($leaverequest->approved_by)) {{$leaverequest->approvedBy->name}} @endif</h6>
                            </div>
                        @endif

                        {{-- {{dd($leaverequest)}} --}}
                        @if($leaverequest->rejected_by)
                            <div class="col-lg-6 col-md-6">
                                <h6 class="pl-3 pt-4">Rejected By: @if(isset($leaverequest->rejected_by) && !empty($leaverequest->rejected_by)) {{$leaverequest->rejectedBy->name}} @endif</h6>
                            </div>
                        @endif

                        @if($leaverequest->approved_date)
                            <div class="col-lg-6 col-md-6">
                                @if($leaverequest->is_approved == "1")
                                    <h6 class="pl-3 pt-4">Approved Date: {{$leaverequest->approved_date}}</h6>
                                @elseif($leaverequest->is_rejected == "1")
                                    <h6 class="pl-3 pt-4">Rejected Date: {{$leaverequest->approved_date}}</h6>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- <div class="row mt-2 justify-content-center">
                        <div class="form-group">
                            <div>
                                <a class="btn btn-light waves-effect ml-1" href="{{ route('leaverequest.index') }}">
                                    <i class="md md-arrow-back"></i>
                                    Back
                                </a>
                                <input type="submit" class="btn btn-danger waves-effect waves-light" value="Submit">
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>


{{-- </form> --}}
@endsection


