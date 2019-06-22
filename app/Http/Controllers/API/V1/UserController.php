<?php

namespace App\Http\Controllers\API\V1;

use App\User;
use Validator;
use App\Device;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $successStatus = 1;
    private $failedStatus = -1;
    private $successUpdate = 2;

    public function info()
    {
        $user = Auth::user();

        return Response()->json([
                'code' => $this->successStatus,
                'message' => 'مشخصات کاربر',
                'data' => [
                    'name' => $user->name,
                    'phone' => $user->phone,
                ]
            ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/(09)[0-9]{9}/',
            'uu_id' => 'required'
        ]);

        if ($validator->fails()) {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user instanceof User) {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => 'کاربر با این شماره وجود نداشته است!',
            ]);
        }

        $user->sendSMS('login', $request->uu_id);

        return response()->json([
            'code' => $this->successStatus,
            'message' => 'کد جدید برایش ارسال شد!',
        ]);

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => $validator->errors()->first()
            ]);
        }
        $usr = Auth::user();
        $usr->name = $request->name;

        if (empty($request->phone)) {

            $usr->save();

            return Response()->json([
                'code' => $this->successStatus,
                'message' => 'تغییر نام انجام شد',
            ]);
        }

        $user = User::where('phone', $request->phone)->first();

        if ($user instanceof User) {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => 'این شماره قبلا ثبت شده است وخطای عدم دسترسی',
            ]);
        }

        $old_user = User::where('phone', $usr->phone)->first();

        $old_user->sendSMSUpdate('update', $request->uu_id, $request->phone);

        $usr->save();

        return Response()->json([

            'code' => $this->successUpdate,
            'message' => 'کد برای شما ارسال شد',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return Response()->json([
            'code' => $this->successStatus,
            'message' => 'کاربر با موفقیت از سیستم خارج شد!'
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'unique:users|max:14||regex:/(09)[0-9]{9}/',
            'uu_id' => 'required',
        ]);

        if ($validator->fails()) {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        $user->sendSMS('register', $request->uu_id);

        return response()->json([
            'code' => $this->successStatus,
            'message' => 'کاربر جدید بوده و کد برایش ارسال شد!',
        ]);
    }

    public function verificationUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:users|regex:/(09)[0-9]{9}/',
            'uu_id' => 'required',
            'code' => 'required|max:5',
        ]);

        if ($validator->fails()) {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = Auth::user();

        $device = $user->devices()->where('uu_id', $request->uu_id)
            ->where('code', $request->code)
            ->first();


        if ($device instanceof Device) {

            $request->user()->token()->revoke();

            $token = Auth::user()->createToken('MyApp')->accessToken;

            $device->update([
                'token' => $token
            ]);

            $user->update([
                'phone' => $request->phone
            ]);

            return Response()->json([
                'code' => $this->successStatus,
                'message' => 'تغییرات شماره انجام شد',
                'data' => [
                    'token' => $token
                ]
            ]);

        } else {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => 'کد صحیح نمی باشد',
            ]);
        }
    }

    public function verificationRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:4',
            'uu_id' => 'required',
            'phone' => 'required|regex:/(09)[0-9]{9}/',
        ]);

        if ($validator->fails()) {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::where('phone', $request->phone)->first();

        if ($user instanceof User) {

            $userFirebase = $user->devices()->where('uu_id', $request->uu_id)
                ->where('code', $request->code)
                ->first();

            if ($userFirebase instanceof Device) {

                $token = $user->createToken('MyApp')->accessToken;

                $userFirebase->update([
                    'token' => $token
                ]);

                return Response()->json([
                    'code' => $this->successStatus,
                    'message' => 'کاربر کد را به درستی وارد کرده و ورود موفق',
                    'data' => $token,
                ]);

            } else

                return Response()->json([
                    'code' => $this->failedStatus,
                    'message' => 'کد صحیح نمی باشد',
                ]);
        } else {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => 'این شماره صحبح نمی باشد',
            ]);
        }
    }
}