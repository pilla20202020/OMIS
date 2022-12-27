@section('css')
    <link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet">
@endsection
@csrf
<div class="row">
    <div class="col-sm-9">
        <div class="card">
            <div class="card-underline">
                <div class="card-head mt-2 p-3">
                    <header>{!! $header !!}</header>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            {{-- <div class="form-group">
                                <input type="text" name="name" class="form-control" required
                                       value="{{ old('name', isset($category->name) ? $category->name : '') }}"/>
                                <span id="textarea1-error" class="text-danger">{{ $errors->first('name') }}</span>
                                <label for="Name">Name</label>
                            </div> --}}

                            <div class="form-group ">
                                <label for="name" class="col-form-label pt-0">Name</label>
                                <div class="">
                                    <input class="form-control" type="text" required name="name" value="{{ old('name', isset($category->name) ? $category->name : '') }}" placeholder="Enter Your Name">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            {{-- <div class="form-group">
                                <input type="text" name="keywords" data-role="tagsinput"
                                       value="{{ old('keywords', isset($category->keywords) ? $category->keywords : '') }}"/>
                                <span id="textarea1-error" class="text-danger">{{ $errors->first('keywords') }}</span>
                                <label for="specialization">Keywords</label>
                            </div> --}}

                            <div class="form-group ">
                                <label for="specialization" class="col-form-label pt-0">Keyword</label>
                                <div class="">
                                    <input class="form-control" type="text" name="keywords" data-role="tagsinput"
                                    value="{{ old('keywords', isset($category->keywords) ? $category->keywords : '') }}" placeholder="Enter a keyword">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label pt-0">Description</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Description">{{old('description',isset($category->description) ? $category->description : '')}}</textarea>
                                <span id="textarea1-error" class="text-danger">{{ $errors->first('description') }}</span>
                            </div>
                        </div>
                    </div>











                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group d-flex">
                            <span class="pl-1">Status</span>
                            <input type="checkbox" id="switch1" switch="none" name="status"
                                {{ old('status', isset($category->status) ? $category->status : '') == 'active' ? 'checked' : '' }} />
                            <label for="switch1" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-2 justify-content-center">
                    <div class="form-group">
                        <div>
                            <a class="btn btn-light waves-effect ml-1" href="{{ route('inventory.category.index') }}">
                                <i class="md md-arrow-back"></i>
                                Back
                            </a>
                            <input type="submit" name="pageSubmit" class="btn btn-danger waves-effect waves-light"
                                value="Submit">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@section('js')

    <script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
    <script>
        $(function () {
            $('.ckeditor').each(function (e) {
            });
        });

        $('.offerd_course').select2({
            tags: true
        });
    </script>
@endsection
