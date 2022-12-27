@section('css')
    <link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet"
          href="{{ asset('resources/css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862')}}"/>
@endsection
@csrf
<div class="row">
    <div class="col-sm-9">
        <div class="card">
            <div class="card-underline">
                <div class="card-head">
                    <header class="ml-3 mt-2">{!! $header !!}</header>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6">

                            <div class="form-group ">
                                <label for="name" class="col-form-label pt-0">Date*</label>
                                <div class="">
                                    <input class="form-control date" type="date" required name="date" value="{{ old('name', isset($holiday->date) ? $holiday->date : '') }}" placeholder="Enter Starting Date">
                                </div>
                            </div>

                        </div>


                        <div class="col-sm-6">

                            <div class="form-group ">
                                <label for="name" class="col-form-label pt-0">Name of Holiday</label>
                                <div class="">
                                    <input class="form-control" type="text" required name="name" value="{{ old('name', isset($holiday->name) ? $holiday->name : '') }}" placeholder="Enter Holiday Name">
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row mt-2 justify-content-center">
                        <div class="form-group">
                            <div>
                                <a class="btn btn-light waves-effect ml-1" href="{{ route('holiday.index') }}">
                                    <i class="md md-arrow-back"></i>
                                    Back
                                </a>
                                <input type="submit" name="pageSubmit" class="btn btn-success waves-effect waves-light" value="Submit">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@section('js')
    <script src="{{asset('resources/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/dropify.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dropify').dropify();
        });
    </script>
@endsection
