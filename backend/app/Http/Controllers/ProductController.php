<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Create a new product.
     *
     * @param  ProductRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductRequest $request){
        try{
            //creating a product using validated data of request 
            $product = Product::create($request->validated());

            //returning json response with the created product
            return response()->json([
                'product' => $product
            ], 201);
        }catch(\Exception $e){
            //returning json response with catched errors
            return response()->json([
                'errors' => $request->errors()
            ], 400);
        }
    }

    /**
     * Return all products in stock.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function inStock(){
        //reading all products with quantity greater than 0
        $products = Product::where('quantity', '>', '0')->get();
        
        //returning json response with the created product
        return response()->json([
            'products' => $products
        ], 200);
    }
}
