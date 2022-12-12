@extends('backend.layouts.master')

@section('content')

<div class="content-wrapper">
        <form class="form form-validate floating-label" action="{{route('inventory.category.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @include('backend.inventory.category.partials.form',['header' => 'Create a Category'])
        </form>
</div>

@stop





