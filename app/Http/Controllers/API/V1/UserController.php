<?php

namespace App\Http\Controllers\API\V1;

use App\User;
use Validator;
use App\Firebase;
use http\Env\Response;
use App\Events\SMSCreated;
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
        return Response()->json(
            [
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
            'device' => 'required'
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

        $device = Firebase::where('user_id', $user->id)
            ->where('device', $request->device)
            ->first();

        if ($device instanceof Firebase) {

            $code = $device->makeVerifyCode();

            $text = __('messages.login', ['code' => $code]);

            event(new SMSCreated($request->phone, $text));

            return response()->json([
                'code' => $this->successStatus,
                'message' => 'کاربر از قبل وجود داشته و کد جدید برایش ارسال شد!',
            ]);

        } else {
            $device = Firebase::create([
                'user_id' => $user->id,
                'device' => $request->device,
            ]);

            $code = $device->makeVerifyCode();

            $text = __('messages.login', ['code' => $code]);

            event(new SMSCreated($request->phone, $text));

            return Response()->json([
                'code' => $this->successStatus,
                'message' => 'کاربر با این وسیله ثبت و کد ارسال شد!',
            ]);
        }
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
        if (empty($request->phone)) {

            Auth::user()->update([
                'name' => $request->name
            ]);

            return Response()->json([
                'code' => $this->successStatus,
                'message' => 'تغییر نام انجام شد',
            ]);

        } else {
            $user = User::where('phone', $request->phone)->first();

            if ($user instanceof User) {

                return Response()->json([
                    'code' => $this->failedStatus,
                    'message' => 'این شماره قبلا ثبت شده است وخطای عدم دسترسی',
                ]);

            } else {
                Auth::user()->update([
                    'name' => $request->name
                ]);

                $user_id = Auth::user()->id;

                $device = Firebase::where('user_id', $user_id)
                    ->where('device', $request->device)
                    ->first();

                $code = $device->makeVerifyCode();

                $text = __('messages.update', ['code' => $code]);

                event(new SMSCreated($request->phone, $text));

                return Response()->json([
                    'code' => $this->successUpdate,
                    'message' => 'کد برای شما ارسال شد',
                ]);
            }
        }
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
            'device' => 'required',
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

        Firebase::create([
            'user_id' => $user->id,
            'device' => $request->device,
        ]);

        $device = Firebase::where('user_id', $user->id)
            ->where('device', $request->device)
            ->first();

        $code = $device->makeVerifyCode();

        $text = __('messages.register', ['user' => $user->name, 'code' => $code]);

        event(new SMSCreated($request->phone, $text));

        return response()->json([
            'code' => $this->successStatus,
            'message' => 'کاربر جدید بوده و کد برایش ارسال شد!',
        ]);
    }

    public function verificationUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:users|regex:/(09)[0-9]{9}/',
            'device' => 'required',
            'code' => 'required|max:5',
        ]);

        if ($validator->fails()) {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = Auth::user();

        $device = Firebase::where('user_id', $user->id)
            ->where('device', $request->device)
            ->where('code', $request->code)
            ->first();


        if ($device instanceof Firebase) {

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
            'device' => 'required',
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

            $userFirebase = Firebase::where('user_id', $user->id)
                ->where('device', $request->device)
                ->where('code', $request->code)
                ->first();

            if ($userFirebase instanceof Firebase) {
                $success['token'] = $user->createToken('MyApp')->accessToken;

                $userFirebase->update([
                    'token' => $success['token']
                ]);

                return Response()->json([
                    'code' => $this->successStatus,
                    'message' => 'کاربر کد را به درستی وارد کرده و ورود موفق',
                    'data' => $success,
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