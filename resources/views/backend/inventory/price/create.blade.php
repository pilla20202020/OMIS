@extends('backend.layouts.master')

@section('content')

<div class="content-wrapper">
        <form class="form form-validate floating-label" action="{{route('inventory.price.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @include('backend.inventory.price.partials.form',['header' => 'Create a price'])
        </form>
</div>

@stop





