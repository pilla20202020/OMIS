@extends('backend.layouts.master')


@section('title', 'Campaign')

@section('content')
    <div class="content-wrapper">

        <form class="form form-validate floating-label" action="{{route('lms.campaign.update',$campaign->id)}}"
                method="POST" enctype="multipart/form-data" novalidate>
        @method('PUT')
        @include('backend.lms.campaign.partials.form', ['header' => 'Edit campaign <span class="text-primary">('.($campaign->name).')</span>'])
        </form>
    </div>
@stop

@push('styles')
    <link href="{{ asset('backend/assets/css/libs/dropify/dropify.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('backend/assets/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/libs/dropify/dropify.min.js') }}"></script>
@endpush

