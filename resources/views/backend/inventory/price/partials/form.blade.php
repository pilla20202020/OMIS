@section('page-specific-styles')
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
                            <div class="form-group ">
                                <label for="name" class="col-form-label pt-0">Price Title</label>
                                <div class="">
                                    <input class="form-control" type="text" required name="name" value="{{ old('name', isset($price->name) ? $price->name : '') }}" placeholder="Enter Your Name">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group ">
                                <label for="name" class="col-form-label pt-0">Value</label>
                                <div class="">
                                    <input class="form-control" type="text" required name="value" value="{{ old('value', isset($price->value) ? $price->value : '') }}" placeholder="Enter Value">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="supplier_id" class="col-form-label pt-0">Product</label>
                                <div class="">
                                    <select data-placeholder="Select Supplier" class="tail-select w-full form-control" name="product_id">
                                        @foreach($product as $product_data)
                                            <option value="{{$product_data->id}}"  @if(isset($supplier_search)) @if($supplier_search->id==$product_data->id) selected @endif @endif>{{ucfirst($product_data->name)}}</option>
                                        @endforeach

                                    </select>
                                </div>
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
                            <span class="pl-1">Is Default</span>
                            <input type="checkbox" id="switch0" switch="none" name="is_default" {{ old('is_default', isset($price->is_default) ? $price->is_default : '')=='yes' ? 'checked':'' }}/>
                            <label for="switch0" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                        </div>
                        <div class="form-group d-flex">
                            <span class="pl-1">Status</span>
                            <input type="checkbox" id="switch1" switch="none" name="status"
                                {{ old('status', isset($price->status) ? $price->status : '') == 'active' ? 'checked' : '' }} />
                            <label for="switch1" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-2 justify-content-center">
                    <div class="form-group">
                        <div>
                            <a class="btn btn-light waves-effect ml-1" href="{{ route('inventory.price.index') }}">
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
