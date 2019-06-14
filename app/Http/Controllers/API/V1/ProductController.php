<?php

namespace App\Http\Controllers\API\V1;

use Validator;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    private $successStatus = 1;
    private $failedStatus = -1;

    public function show(Product $product)
    {
        if (Auth::user()->id != $product->user_id) {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => 'عدم دسترسی',

            ]);
        }

        return Response()->json([
            'code' => $this->successStatus,
            'message' => 'نمایش یک محصول',
            'data' => $product,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'warranty_number' => 'required|unique:products',
            'purchase_date' => 'required',
            'end_date_of_warranty' => 'required',

        ]);

        if ($validator->fails()) {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => $validator->errors()->first()
            ]);
        }

        $product = Product::create(
            array_merge($request->except('image'), ['user_id' => Auth::user()->id])
        );

        $product->storeProduct($request->file('image'));

        return Response()->json([
            'code' => $this->successStatus,
            'message' => 'محصول با موفقیت ثبت شد!',
        ]);
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'status' => 'required|in:all,expired,valid,expiring'
        ]);

        if ($validator->fails()) {
            return Response()->json([
                'code' => $this->failedStatus,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = Auth::user();

        $products = Product::where('user_id', $user->id);

        switch ($request->status)
        {
            case    'expired':
                $products->expired();
                break;
            case    'valid':
                $products->valid();
                break;
            case    'expiring':
                $products->expiring();
                break;
        }

        return response()->json([
                "code" => $this->successStatus,
                "message" => "نمایش همه محصولات",
                "data" => $products->paginate(config('page.paginate_page'))
                    ->map(function ($product) {

                        return $product->except([
                                'created_at',
                                'updated_at'
                            ]
                        );
                    }),
                'has_more' => $products->hasMorePages()
            ]
        );

    }

    public function destroy(Product $product)
    {
        if ($product != null) {
            $product->deleteProduct();

            return Response()->json([
                'code' => $this->successStatus,
                'message' => 'محصول با موفقیت حذف شد!',
            ]);
        }
    }

    public function Downloadlink($filename)
    {
        $file_path = 'picture/upload/' . $filename;

        if (file_exists($file_path))
        {
            return Response::file($file_path);
        }
        else {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => 'چنین عکسی موجود نمی باشد',
            ]);
        }
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'warranty_number' => 'required',
            'purchase_date' => 'required',
            'end_date_of_warranty' => 'required',

        ]);

        if ($validator->fails()) {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => $validator->errors()->first()
            ]);
        }

        if (Auth::user()->id == $product->user_id) {

            if (!empty($request->all())) {
                $product->update(
                    $request->except('image'));

                $product->updateProduct($request->file('image'));

            }

            return Response()->json([
                'code' => $this->successStatus,
                'message' => 'محصول با موفقیت تغییر کرد!',
            ]);
        }
        else {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => 'خطای عدم دسترسی',
            ]);
        }
    }

}
