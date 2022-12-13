@extends('backend.layouts.master')

@section('content')

<div class="content-wrapper">
        <form class="form form-validate floating-label" action="{{route('inventory.purchaseentry.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @include('backend.inventory.purchase_entry.partials.form',['header' => 'Create a Purchase Entry'])
        </form>
</div>

@stop





