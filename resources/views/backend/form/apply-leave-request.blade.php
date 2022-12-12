@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h3 class="card-title">{{ $form_name }}</h3>

                    </div>
                    <div class="col-sm-8">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ $form_name }}</li>
                        </ol>
                    </div>
                </div>
            </div>

            <form class="form-horizontal" action="{{ route('form.application.store', [$form_name]) }}" method="post" id="modalForm">
                @csrf
                @php
                    $formFields = json_decode($formDetails->form_detail, true);
                    unset($formFields['result'][0]);
                    unset($formFields['result'][1]);
                    // dd($formFields);
                    $employees = getEmployees(auth()->user()->company_id);
                @endphp
                <div class="card-body">

                    @foreach ($formFields['result'] as $key => $item)
                        @if ($item['type'] == 'select' && $item['name'] == 'EmployeeId')
                            <div class="form-group row">
                                <label for="{{ $item['name'] }}"
                                    class="col-sm-2 col-form-label">{{ $item['label'] }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="{{ $item['name'] }}" id="{{ $item['name'] }}">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->emp_id }}">{{ $employee->first_name }}
                                                {{ $employee->first_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @elseif($item['type'] == 'text' && $item['name'] == 'EmailTrigger')
                            <div id="custom_email_trigger">
                                <div class="form-group row">
                                    <label for="{{ $item['name'] }}"
                                        class="col-sm-2 col-form-label">{{ $item['label'] }}</label>
                                    <div class="col-sm-8">
                                        <input type="{{ $item['subtype'] }}" class="form-control" id="{{ $item['name'] }}"
                                            name="{{ $item['name'] }}[]"
                                            placeholder="{{ isset($item['placeholder']) ? $item['placeholder'] : '' }}">
                                    </div>
                                    <button type="button"
                                        class="col-sm-1 btn btn-block btn-primary email_trigger_add">Add</button>
                                </div>
                            </div>
                        @else
                            <div class="form-group row">
                                <label for="{{ $item['name'] }}"
                                    class="col-sm-2 col-form-label">{{ $item['label'] }}</label>
                                <div class="col-sm-8">
                                    <input type="{{ $item['subtype'] }}" class="form-control" id="{{ $item['name'] }}"
                                        name="{{ $item['name'] }}" 
                                        placeholder="{{ isset($item['placeholder']) ? $item['placeholder'] : '' }}">
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <button type="submit" class="offset-sm-2 col-sm-1 btn btn-block btn-success">Submit</button>

                </div>


                <!-- /.card-body -->
                {{-- <div class="card-footer">
                  <button type="submit" class="btn btn-info">Sign in</button>
                  <button type="submit" class="btn btn-default float-right">Cancel</button>
                </div> --}}
                <!-- /.card-footer -->
            </form>
        </section>
    </div>

    <!-- Main content -->
@endsection
@section('css')

    <style>
.ck-editor__editable {
    min-height: 400px;
}
    </style>
@stop

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.email_trigger_add', function() {
                let html = `<div class="form-group row">
	                            <div class="offset-sm-2 col-sm-8">
		                    <input type="email" class="form-control" id="EmailTrigger" name="EmailTrigger[]" placeholder="Enter Email">
	                    </div>
	                    <button type="button" class="col-sm-1 btn btn-block btn-danger email_trigger_remove">Remove</button>
                        </div>`;

                $('#custom_email_trigger').append(html);
            })
            $(document).on('click', '.email_trigger_remove', function() {
                $(this).parent().remove();

                // $('#custom_email_trigger').remove(html);
            })

            ClassicEditor
                .create(document.querySelector('#EmailContent'))
                .catch(error => {
                    console.error(error);
                });
        })
    </script>
@stop
