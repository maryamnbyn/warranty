<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json(
            [
                "code" => 1 ,
                "message" => "نمایش همه محصولات",
                "data" => $products
            ]
        );
    }
    public function create()
    {

    }
    public function store()
    {

    }
    public function edit()
    {

    }
    public function update()
    {

    }
    public function destroy()
    {

    }
}
