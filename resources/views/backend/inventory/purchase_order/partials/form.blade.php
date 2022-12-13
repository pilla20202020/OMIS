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
                        <div class="col-sm-4">
                            <div class="form-group ">
                                <label for="requested_stock" class="col-form-label pt-0">Purchase Order Invoice</label>
                                <div class="">
                                    <input class="form-control" type="number" required name="invoice" value="{{ old('invoice', isset($purchaseorder->invoice) ? $purchaseorder->invoice : '') }}" placeholder="Enter Purchase Order Invoice">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group ">
                                <label for="product_id" class="col-form-label pt-0">Product</label>
                                <div class="">
                                    <select data-placeholder="Select Product" class="tail-select w-full form-control purchase_class product_class" name="product_id">
                                            @foreach($product as $product_data)
                                                <option value="{{$product_data->id}}"  @if(isset($product_search)) @if($product_search->id==$product_data->id) selected @endif @endif>{{ucfirst($product_data->name)}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group ">
                                <label for="requested_stock" class="col-form-label pt-0">Quantity</label>
                                <div class="">
                                    <input class="form-control" type="number" required name="requested_stock" value="{{ old('requested_stock', isset($purchaseorder->requested_stock) ? $purchaseorder->requested_stock : '') }}" placeholder="Enter Quantity">
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="buying_price" class="col-form-label pt-0">Buying Price</label>
                                <div class="">
                                    <input class="form-control" type="number" required name="buying_price" value="{{ old('buying_price', isset($purchaseorder->buying_price) ? $purchaseorder->buying_price : '') }}" placeholder="Enter Buying Price">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="buying_date" class="col-form-label pt-0">Buying Date</label>
                                <div class="">
                                    <input class="form-control" type="date" required name="buying_date" value="{{ old('buying_date', isset($purchaseorder->buying_date) ? $purchaseorder->buying_date : '') }}" placeholder="Enter Buying Price">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label pt-0">Description</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Description">{{old('description',isset($purchaseorder->description) ? $purchaseorder->description : '')}}</textarea>
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
                                {{ old('status', isset($purchaseorder->status) ? $purchaseorder->status : '') == 'active' ? 'checked' : '' }} />
                            <label for="switch1" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-2 justify-content-center">
                    <div class="form-group">
                        <div>
                            <a class="btn btn-light waves-effect ml-1" href="{{ route('inventory.purchaseorder.index') }}">
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
