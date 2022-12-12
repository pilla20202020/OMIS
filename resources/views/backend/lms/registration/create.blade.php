@extends('backend.layouts.master')

@section('content')

<div class="content-wrapper">
        <form class="form form-validate floating-label" action="{{route('lms.campaign.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @include('backend.lms.campaign.partials.form',['header' => 'Create a Campaign'])
        </form>
</div>

@stop





