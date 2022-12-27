@extends('backend.layouts.master')

@section('title', 'Add Leave Request')

@section('content')
<div class="content-wrapper">
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label custom-validation" action="{{route('leaverequest.store')}}" method="POST" enctype="multipart/form-data">
            @include('backend.leave.leave_request.form',['header' => 'Add Leave Request'])
            </form>
        </div>
    </section>
</div>
@endsection

