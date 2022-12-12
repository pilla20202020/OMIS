<?php

namespace App\Http\Controllers\Inventory\Product;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Brand\Brand;
use App\Models\Category\Category;
use App\Models\HRIS\Branch;
use App\Models\Price\Price;
use App\Models\Product\Product;
use App\Service\Branch\BranchService;
use App\Service\Brand\BrandService;
use App\Service\Category\CategoryService;
use App\Service\price\PriceService;
use App\Service\Product\ProductService;
use App\Service\supplier\supplierService;
use App\Service\Unit\unitService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $product, $brand, $category, $supplier, $unit, $price, $branch;

    function __construct(ProductService $product, CategoryService $category, BrandService $brand, SupplierService $supplier, UnitService $unit,PriceService $price, GeneralHelper $generalhelper)
    {
        $this->product = $product;
        $this->brand = $brand;
        $this->category = $category;
        $this->supplier = $supplier;
        $this->unit = $unit;
        $this->price = $price;
        $this->generalhelper = $generalhelper;

    }
    public function index()
    {
        //
        $product = $this->product->paginate();
        return view('backend.inventory.product.index',compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function getAllData()
    {
        // dd($this->product);
        return $this->product->getAllData();
    }

    public function create()
    {
        //

        $branch = $this->generalhelper->getCompanies();
        $category = $this->category->paginate();
        $supplier = $this->supplier->paginate();
        $unit = $this->unit->paginate();
        return view('backend.inventory.product.create',compact('branch','category','supplier','unit'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if($product = $this->product->create($request->all())) {
            if($request->hasFile('image')) {
                $this->uploadFile($request, $product);
            }
            return redirect()->route('inventory.product.index');

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
        $product = $this->product->find($id);
        $branch = $this->generalhelper->getCompanies();
        $branch_search = Branch::find($product->branch_id);
        $category_search = $this->category->find($product->category_id);
        $category =$this->category->paginate();
        $unit = $this->unit->paginate();
        $supplier = $this->supplier->paginate();
        $supplier_search = $this->supplier->find($product->supplier_id);
        $unit_search = $this->unit->find($product->unit_id);
        $prices = $this->price->findProduct($product->id);
        return view('backend.inventory.product.edit',compact('product','branch','category','branch_search','category_search','supplier','supplier_search','unit','unit_search','prices'));
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

        if($this->product->update($id,$request->all()))
        {
            if ($request->hasFile('image')) {
                $product = $this->product->find($id);
                $this->uploadFile($request, $product);
            }
            return redirect()->route('inventory.product.index');
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
        if($this->product->delete($id)) {
            return response()->json(['status'=>true]);
        }
    }

    function uploadFile(Request $request, $product)
    {
        $file = $request->file('image');
        $fileName = $this->product->uploadFile($file);
        if (!empty($product->image))
            $this->product->__deleteImages($product);

        $data['image'] = $fileName;
        $this->product->updateImage($product->id, $data);

    }

    public function categoryProductAjax(Request $request)
    {
        $product = $this->product->getByCategoryId($request->category_id);
        return response()->json([
            'data' => $product,
            'status' => true,
            'message' => "Unit Added Successfully."
        ]);

    }
}
