@extends('backend.layouts.master')

@section('content')

<div class="content-wrapper">
        <form class="form form-validate floating-label" action="{{route('inventory.purchaseorder.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        @include('backend.inventory.purchase_order.partials.form',['header' => 'Create a Purchase Order'])
        </form>
</div>

@stop





