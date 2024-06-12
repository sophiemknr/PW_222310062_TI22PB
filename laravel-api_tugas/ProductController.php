<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Product $product){
        $data = $product->all();

        return new ProductResource(200, "Success!", $data);
    }

    public function store(Request $request){
        $dataRequest = $request->all(["name", "desc", "qty", "price"]);

        $validate = Validator::make($dataRequest, [
            "name" => ["required", "max:100"],
            "desc" => ["required", "max:100"],
            "qty" => ["required"],
            "price" => ["required"]
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
        }

        $data = Product::create($dataRequest);

        return new ProductResource(201, "Created successfully", $data);
    }

    public function show(Product $product){
        return new ProductResource(200, "Success!", $product);
    }

    public function update(Request $request, Product $product) {
        $dataRequest = $request->all(["name", "desc", "qty", "price"]);

        $validate = Validator::make($dataRequest, [
            "name" => ["sometimes", "required", "max:100"],
            "desc" => ["sometimes", "required", "max:100"],
            "qty" => ["sometimes", "required"],
            "price" => ["sometimes", "required"]
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
        }

        $product->update($dataRequest);

        return new ProductResource(200, "Updated successfully", $product);
    }

    public function destroy(Product $product) {
        $product->delete();

        return response()->json(null, 204);
    }
}
