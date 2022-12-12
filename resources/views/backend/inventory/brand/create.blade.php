@extends('backend.layouts.master')

@section('content')

<div class="content-wrapper">
        <form class="form form-validate floating-label" action="{{route('inventory.brand.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @include('backend.inventory.brand.partials.form',['header' => 'Create a Brand'])
        </form>
</div>

@stop





