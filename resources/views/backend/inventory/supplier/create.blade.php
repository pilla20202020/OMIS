@extends('backend.layouts.master')

@section('content')

<div class="content-wrapper">
        <form class="form form-validate floating-label" action="{{route('inventory.supplier.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @include('backend.inventory.supplier.partials.form',['header' => 'Create a supplier'])
        </form>
</div>

@stop





