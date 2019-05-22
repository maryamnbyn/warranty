<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\User;
use http\Env\Response;
use Validator;
use Illuminate\Http\Request;

/**
 * @property  successStatus
 */
class UserController extends Controller
{
    private $successStatus = 1;
    private $failedStatus = -1;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'phone' => 'required'
            ]);
        if ($validator->fails()) {
            $validate = collect($validator->errors());
            return Response()->json(
                [
                    'code' => $this->failedStatus,
                    'message' => $validate->collapse()[0]
                ]);
        }

        $phone = $request->phone;
        $user = User::where('phone', $phone)->first();

        if (!empty($user)) {
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return Response()->json([
                'code' => $this->successStatus,
                'message' => 'ورود موفق',
                'data' => $success
            ]);
        } else {
            return Response()->json([
                'code' => $this->failedStatus,
                'message' => 'خطای عدم دسترسی',
            ]);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'phone' => 'required|unique:users'
            ]);
        if ($validator->fails()) {
            $validate = collect($validator->errors());
            return Response()->json([
                    'code' => $this->failedStatus,
                    'message' => $validate->collapse()[0]
                ]
            );
        }
        $name = $request->name;
        $phone = $request->phone;
        User::create([
                'name' => $name,
                'phone' => $phone,
                'code' => 4444
            ]
        );
        return response()->json([
            'code' => $this->successStatus,
            'message' => 'کد برای شما ارسال شد!',
        ]);

    }

    public function verification(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'code' => 'required'
            ]);
        if ($validator->failed()) {
            $validate = collect($validator->errors());
            return response()->json(
                [
                    'code' => $this->failedStatus,
                    'message' => $validate->collapse()[0]
                ]
            );
        }
        $phone = $request->phone;
        $code = $request->code;
        $userPhone = User::where('phone', $phone)->first();
        $userCode = $userPhone->code;
        if ($code == $userCode) {
            $success['token'] = $userPhone->createToken('MyApp')->accessToken;

            return Response()->json(
                [
                    ' code' => $this->successStatus,
                    'message' => 'ورود موفق',
                    'data' => $success,
                ]);
        } else
            return Response()->json(
                [
                    ' code' => $this->failedStatus,
                    'message' => 'خطای عدم دسترسی',
                ]);
    }
}

                          