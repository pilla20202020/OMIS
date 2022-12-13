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
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="product_id" class="col-form-label pt-0">Product</label>
                                <div class="">
                                    <input class="form-control purchase_product_name" readonly value={{$purchase_entry->product->name}}>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="available_stock" class="col-form-label pt-0">Available Quantity</label>
                                <div class="">
                                    <input class="form-control" type="number" name="available_stock" placeholder="Enter Quantity" value={{$purchase_entry->available_stock}}>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="defective_stock" class="col-form-label pt-0">Defective Quntity</label>
                                <div class="">
                                    <input class="form-control" type="number" name="defective_stock" placeholder="Enter Defective Quantity" value={{$purchase_entry->defective_stock}}>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="buying_price" class="col-form-label pt-0">Buying Price</label>
                                <div class="">
                                    <input class="form-control" type="number" name="buying_price" placeholder="Enter Buying Price" value={{$purchase_entry->buying_price}}>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="buying_date" class="col-form-label pt-0">Buying Date</label>
                                <div class="">
                                    <input class="form-control" type="date" name="buying_date" placeholder="Enter Buying Date" value={{$purchase_entry->buying_date}}>
                                </div>
                            </div>
                        </div>


                    </div>


                    <hr>
                    <div class="row mt-2 justify-content-center">
                        <div class="form-group">
                            <div>
                                <a class="btn btn-light waves-effect ml-1" href="{{ route('inventory.purchaseentry.index') }}">
                                    <i class="md md-arrow-back"></i>
                                    Back
                                </a>
                                <input type="submit" name="pageSubmit" class="btn btn-danger waves-effect waves-light" value="Submit">
                            </div>
                        </div>
                    </div>








                </div>
            </div>
        </div>
    </div>


</div>
