<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = product::all();

        if($products){
            return view('product.viewproduct', ['products'=>$products]);
        }else{
            return view('product.viewproduct');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('product.createproduct');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validation = Validator::make($request->all() ,[
            'name' => 'required|unique:products|max:200',
            'sku' => 'required|unique:products|max:200',
            'price' => 'required',
            'image' => 'image|mimes:jpg,jpeg'
        ]);

        if($validation->fails()){

            $validationmessages = $validation->messages()->all();
            return view('product.createproduct',['errors'=>$validationmessages]);

        }

        if(!isset($request->status)){
            $request->status = 0;
        }

        if($request->hasFile('image')){

            $imageName = time().$request->image->extension();

            $request->image->move(public_path('images'), $imageName);

            $store = product::create([
                'name' => $request->name,
                'sku' => $request->sku,
                'price' => $request->price,
                'image' => $imageName,
                'status' => $request->status
            ]);

        }else{

            $store = product::create([
                'name' => $request->name,
                'sku' => $request->sku,
                'price' => $request->price,
                'status' => $request->status
            ]);
        }

        if($store){
            return redirect( route('product.view'));
        }else{
            return view('product.createproduct',['errors'=>$store->errors()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product, $product_id)
    {
        //

        $singleProduct = product::where('id', $product_id)->first();

        return view('product.createproduct', ['singleProduct'=>$singleProduct]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product, $product_id)
    {
        //

        $validation = Validator::make($request->all() ,[
            'name' => 'required|max:200',
            'sku' => 'required|max:200',
            'price' => 'required',
            'image' => 'image|mimes:jpg,jpeg'
        ]);

        $singleProduct = product::where('id',$product_id)->first();

        $updatedata = [];
        if($singleProduct->name != $request->name){
            $updatedata['name'] = $request->name;
        }
        if($singleProduct->sku != $request->sku){
            $updatedata['sku'] = $request->sku;
        }
        if($singleProduct->price != $request->price){
            $updatedata['price'] = $request->price;
        }
        if($request->status){
            $updatedata['status'] = $request->status;
        }else{
            $updatedata['status'] = 0;
        }

        if($validation->fails()){

            $validationmessages = $validation->messages()->all();
            return view('product.createproduct',['errors'=>$validationmessages]);

        }

        if($request->hasFile('image')){

            $imageName = time().$request->image->extension();

            $request->image->move(public_path('images'), $imageName);

            $updatedata['image'] = $imageName;

            $store = product::where('id',$product_id)->update($updatedata);

        }else{

            $store = product::where('id',$product_id)->update($updatedata);

        }

        if($store){
            return redirect( route('product.view'));
        }else{
            return view('product.createproduct',['errors'=>$store->errors()]);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product, $product_id)
    {
        //
        $status = product::where('id',$product_id)->delete();

        if($status){
            return redirect( route('product.view'));
        }else{
            return view('product.createproduct',['errors'=>$status->errors()]);
        }

    }

    // APIs

    public function viewProducts()
    {
        //
        $products = product::all();

        return response()->json($products);
    }

    public function viewActiveProducts()
    {
        //
        $products = product::where('status',1)->get();

        return response()->json($products);
    }

    public function viewSingleProduct($product_id)
    {
        //
        $singleProduct = product::where('id',$product_id)->first();

        return response()->json($singleProduct);
    }

    public function addProduct(Request $request)
    {
        //

        $validation = Validator::make($request->all() ,[
            'name' => 'required|unique:products|max:200',
            'sku' => 'required|unique:products|max:200',
            'price' => 'required',
            'image' => 'image|mimes:jpg,jpeg'
        ]);

        if($validation->fails()){

            return response()->json($validation->messages());

        }

        if(!isset($request->status)){
            $request->status = 0;
        }

        if($request->hasFile('image')){

            $imageName = time().$request->image->extension();

            $request->image->move(public_path('images'), $imageName);

            $store = product::create([
                'name' => $request->name,
                'sku' => $request->sku,
                'price' => $request->price,
                'image' => $imageName,
                'status' => $request->status
            ]);

        }else{

            $store = product::create([
                'name' => $request->name,
                'sku' => $request->sku,
                'price' => $request->price,
                'status' => $request->status
            ]);
        }

        return response()->json($store);
    }

    public function updateProduct(Request $request, $product_id)
    {

        $validation = Validator::make($request->all() ,[
            'name' => 'required|max:200',
            'sku' => 'required|max:200',
            'price' => 'required',
            'image' => 'image|mimes:jpg,jpeg'
        ]);

        $singleProduct = product::where('id',$product_id)->first();

        $updatedata = [];
        if($singleProduct->name != $request->name){
            $updatedata['name'] = $request->name;
        }
        if($singleProduct->sku != $request->sku){
            $updatedata['sku'] = $request->sku;
        }
        if($singleProduct->price != $request->price){
            $updatedata['price'] = $request->price;
        }
        if($request->status){
            $updatedata['status'] = $request->status;
        }else{
            $updatedata['status'] = 0;
        }

        if($validation->fails()){

            $validationmessages = $validation->messages()->all();
            return response()->json($validation->messages());

        }

        if($request->hasFile('image')){

            $imageName = time().$request->image->extension();

            $request->image->move(public_path('images'), $imageName);

            $updatedata['image'] = $imageName;

            $store = product::where('id',$product_id)->update($updatedata);

        }else{

            $store = product::where('id',$product_id)->update($updatedata);

        }

        $singleproduct = product::where('id', $product_id)->first();

        return response()->json($singleproduct);

    }

    public function deleteProduct(product $product, $product_id)
    {
        //
        $status = product::where('id',$product_id)->delete();

        if($status){
            return response()->json(['message'=>'Product Deleteed']);
        }else{
            return response()->json(['errors'=>'Product not exist!']);
        }

    }

}
