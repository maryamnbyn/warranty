<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::paginate(config('page.paginate_page'));
        return view('panel.products.index', compact('products'));
    }

    public function destroy(Product $product)
    {
        if ($product != null) {
            $product->delete();
            return redirect()->back();
        }
    }

    public function edit(Product $product)
    {
        return view('panel.products.edit', compact('product'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $user =$product->user();

        $user->update([
            'name' => $request->input('user_name')
        ]);

        $product->update([
            'name' => $request->name,
            'purchase_date' => $request->input('purchase_date'),
            'warranty_number' => $request->input('warranty_number'),
            'end_date_of_warranty' => $request->input('end_date_of_warranty'),
            'factor_number' => $request->input('factor_number'),
            'seller_phone' => $request->input('seller_phone'),
        ]);

        return redirect()->route('admin.products.index');
    }
}
