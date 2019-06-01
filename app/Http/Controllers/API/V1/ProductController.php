<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Validator;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private $successStatus = 1;
    private $failedStatus = -1;

    public function index(Request $request)
    {
        $status = $request->status;
        $user_id = Auth::user()->token()->user_id;

        $products = Product::where('user_id', $user_id)->paginate(config('page.paginate_page'));

        if ($status == 'all') {

            return response()->json(
                [
                    "code" => $this->successStatus,
                    "message" => "نمایش همه محصولات",
                    "data" =>
                        collect($products->items())->map(function ($products) {
                            return collect($products)->except([
                                    'created_at',
                                    'updated_at'
                                ]
                            );
                        }),
                    'has_more' => $products->hasMorePages()

                ]
            );
        } elseif ($status == 'expired') {
            $now = Carbon::now();
            $products = Product::where('user_id', $user_id)
                ->where('end_date_of_warranty', '<', $now)
                ->paginate(config('page.paginate_page'));

            return response()->json(
                [
                    "code" => $this->successStatus,
                    "message" => "نمایش همه محصولات منقضی شده",
                    "data" => collect($products->items())->map(function ($products) {
                        return collect($products)->except([
                                'created_at',
                                'updated_at'
                            ]
                        );
                    }),
                    'has_more' => $products->hasMorePages()

                ]
            );
        } elseif ($status == 'valid') {
            $now = Carbon::now();
            $products = Product::where('user_id', $user_id)
                ->where('end_date_of_warranty', '>', $now)
                ->paginate(config('page.paginate_page'));

            return response()->json(
                [
                    "code" => $this->successStatus,
                    "message" => "نمایش همه محصولات دارای گارانتی",
                    "data" => collect($products->items())->map(function ($products) {
                        return collect($products)->except([
                                'created_at',
                                'updated_at'
                            ]
                        );
                    }),
                    'has_more' => $products->hasMorePages()

                ]
            );
        } elseif ($status == 'expiring') {
            $now = Carbon::now();
            $two_month_ago = $now->subMonth(2);
            $now_1 = Carbon::now();

            $products = Product::where('user_id', $user_id)
                ->whereBetween('end_date_of_warranty', [$two_month_ago, $now_1])
                ->paginate(config('page.paginate_page'));

            return response()->json(
                [
                    "code" => $this->successStatus,
                    "message" => "نمایش همه محصولات در حال انقضا",
                    "data" => collect($products->items())->map(function ($products) {
                        return collect($products)->except([
                                'created_at',
                                'updated_at'
                            ]
                        );
                    }),
                    'has_more' => $products->hasMorePages()

                ]
            );
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'warranty_number' => 'required|unique:products',
            'purchase_date' => 'required',
            'image' => 'required',
            'end_date_of_warranty' => 'required',
            'factor_number' => 'required',
            'reminder_date' => 'required',
            'seller_phone' => 'required',
            'store_address' => 'required',
        ]);

        if ($validator->fails()) {
            $validate = collect($validator->errors());

            return Response()->json(
                [
                    'code' => $this->failedStatus,
                    'message' => $validate->collapse()[0]
                ]);
        }

        $image = $request->file('image');
        $product = Product::create(
            $request->except('image'));
        $product->storeProduct($image);

        return Response()->json([
            'code' => $this->successStatus,
            'message' => 'محصول با موفقیت ثبت شد!',
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'warranty_number' => 'required|unique:products',
            'purchase_date' => 'required',
            'image' => 'required',
            'end_date_of_warranty' => 'required',
            'factor_number' => 'required',
            'reminder_date' => 'required',
            'seller_phone' => 'required',
            'store_address' => 'required',
        ]);

        if ($validator->fails()) {
            $validate = collect($validator->errors());

            return Response()->json(
                [
                    'code' => $this->failedStatus,
                    'message' => $validate->collapse()[0]
                ]);
        }

        $image = $request->file('image');

        $product->update(
            $request->except('image'));
        $product->updateProduct($image);

        return Response()->json([
            'code' => $this->successStatus,
            'message' => 'محصول با موفقیت تغییر کرد!',
        ]);
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

}
