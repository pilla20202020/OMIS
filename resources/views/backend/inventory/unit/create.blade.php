@extends('backend.layouts.master')

@section('content')

<div class="content-wrapper">
        <form class="form form-validate floating-label" action="{{route('inventory.unit.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @include('backend.inventory.unit.partials.form',['header' => 'Create a unit'])
        </form>
</div>

@stop





