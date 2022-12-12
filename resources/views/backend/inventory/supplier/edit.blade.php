@extends('backend.layouts.master')


@section('title', 'supplier')

@section('content')
    <div class="content-wrapper">

        <form class="form form-validate floating-label" action="{{route('inventory.supplier.update',$supplier->id)}}"
                method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('backend.inventory.supplier.partials.form', ['header' => 'Edit supplier <span class="text-primary">('.($supplier->name).')</span>'])
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

