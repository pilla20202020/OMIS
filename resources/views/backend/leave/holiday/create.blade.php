@extends('backend.layouts.master')

@section('title', 'Create a Holiday')

@section('content')
<div class="content-wrapper">
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('holiday.store')}}" method="POST" enctype="multipart/form-data">
            @include('backend.leave.holiday.form',['header' => 'Create a Holiday'])
            </form>
        </div>
    </section>
</div>
@endsection

