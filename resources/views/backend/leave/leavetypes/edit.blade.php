@extends('backend.layouts.master')

@section('css')
    <link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
@endsection

@section('title',$leavetypes->name)

@section('content')
<div class="content-wrapper">
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('leavetypes.update',$leavetypes->id)}}"
                  method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('backend.leave.leavetypes.form', ['header' => 'Edit Absent Types <span class="text-primary">('.($leavetypes->name).')</span>'])
            </form>
        </div>
    </section>
</div>

@endsection


@section('js')
    <script src="{{ asset('js/dropify.min.js') }}"></script>
    <script src="{{ asset('resources/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dropify').dropify();
        });
    </script>
@endsection

