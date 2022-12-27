@extends('backend.layouts.master')

@section('title', 'Create a Leave Types')

@section('content')
<div class="content-wrapper">
    <section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('leavetypes.store')}}" method="POST" enctype="multipart/form-data">
            @include('backend.leave.leavetypes.form',['header' => 'Create a Leave Types'])
            </form>
        </div>
    </section>
</div>
@endsection

