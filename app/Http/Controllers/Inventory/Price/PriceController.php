<?php

namespace App\Http\Controllers\Inventory\Price;

use App\Http\Controllers\Controller;
use App\Http\Requests\Price\PriceRequest;
use App\Service\price\PriceService;
use App\Service\Product\ProductService;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    protected $price, $product;

    function __construct(PriceService $price, ProductService $product)
    {
        $this->price = $price;
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $prices = $this->price->paginate();
        return view('backend.inventory.price.index',compact('prices'));
    }

    public function getAllData()
    {
        // dd($this->role);
        return $this->price->getAllData();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $product  = $this->product->paginate();
        return view('backend.inventory.price.create',compact('product'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PriceRequest $request)
    {
        //
        if($price = $this->price->create($request->all())) {
            return redirect()->route('inventory.price.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $price = $this->price->find($id);
        $product  = $this->product->paginate();
        return view('backend.inventory.price.edit',compact('price','product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if($this->price->update($id,$request->all()))
        {
            if ($request->hasFile('image')) {
                $price = $this->price->find($id);
                $this->uploadFile($request, $price);
            }
            return redirect()->route('inventory.price.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function productPriceAjax(Request $request)
    {
        $price = $this->price->getByProductId($request->product_id);
        if($price) {
            return response()->json([
                'data' => $price,
                'status' => true,
                'message' => "Default Price Found."
            ]);
        } else {
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => "Default Price Not Found."
            ]);
        }


    }
}
