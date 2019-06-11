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

            $validate = collect($validator->errors());

            return Response()->json(
                [
                    'code' => $this->failedStatus,
                    'message' => $validate->collapse()[0]
                ]);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!empty($user)) {

            $check_device = Firebase::where('user_id', $user->id)
                ->where('device', $request->device)
                ->first();

            if (!empty($check_device)) {

                event(new SMSCreated($user->id, $request->device, $request->phone));

                return response()->json([
                    'code' => $this->successStatus,
                    'message' => 'کاربر از قبل وجود داشته و کد جدید برایش ارسال شد!',
                ]);

            }
            else {

                Firebase::create([
                    'user_id' => $user->id,
                    'device' => $request->device,
                ]);

                event(new SMSCreated($user->id, $request->device, $request->phone));

                return Response()->json([
                    'code' => $this->successStatus,
                    'message' => 'کاربر با این وسیله ثبت و کد ارسال شد!',
                ]);
            }
        }

        return Response()->json([
            'code' => $this->failedStatus,
            'message' => 'کاربر با این شماره وجود نداشته است!',
        ]);
    }

    public function update(Request $request)
    {
        if (empty($request->phone)) {
            Auth::user()->update([
                'name' => $request->name
            ]);

            return Response()->json([
                'code' => $this->successStatus,
                'message' => 'تغییر نام انجام شد',
            ]);

        }
        else {
            $user = User::where('phone', $request->phone)->first();

            if (!empty($user)) {

                return Response()->json([
                    'code' => $this->failedStatus,
                    'message' => 'این شماره قبلا ثبت شده است وخطای عدم دسترسی',
                ]);

            } else {

                event(new SMSCreated(Auth::user()->id, $request->device, $request->phone));

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
            $validate = collect($validator->errors());

            return Response()->json(
                [
                    'code' => $this->failedStatus,
                    'message' => $validate->collapse()[0]
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

        event(new SMSCreated($user->id, $request->device, $request->phone));

        return response()->json([
            'code' => $this->successStatus,
            'message' => 'کاربر جدید بوده و کد برایش ارسال شد!',
        ]);
    }

    public function verificationUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/(09)[0-9]{9}/',
            'device' => 'required',
            'code' => 'required|max:5',
        ]);

        if ($validator->fails()) {
            $validate = collect($validator->errors());

            return Response()->json(
                [
                    'code' => $this->failedStatus,
                    'message' => $validate->collapse()[0]
                ]);
        }

        $user_id = Auth::user()->token()->user_id;

        $check_device = Firebase::where('user_id', $user_id)
            ->where('device', $request->device)
            ->first();

        $user_code = $check_device['code'];

        if ($request->code == $user_code) {
            $success['token'] = Auth::user()->createToken('MyApp')->accessToken;

            if (empty($request->name)) {
                $check_device->update([
                    'token' => $success['token']
                ]);

                Auth::user()->update([
                    'phone' => $request->phone
                ]);

                return Response()->json([
                    'code' => $this->successStatus,
                    'message' => 'تغییرات شماره انجام شد',
                    'data' => $success
                ]);

            }
            else {
                $check_device->update([
                    'token' => $success['token']
                ]);

                Auth::user()->update([
                    'name' => $request->name,
                    'phone' => $request->phone
                ]);

                return Response()->json([
                    'code' => $this->successStatus,
                    'message' => 'تغییرات نام و شماره انجام شد',
                    'data' => $success
                ]);
            }

        }
        else {

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

            $validate = collect($validator->errors());

            return Response()->json(
                [
                    'code' => $this->failedStatus,
                    'message' => $validate->collapse()[0]
                ]);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!empty($user)) {
            $userID = $user->id;

            $userFirebase = Firebase::where('user_id', $userID)
                ->where('device', $request->device)
                ->first();

            $userCode = $userFirebase->code;

            if ($request->code == $userCode) {
                $success['token'] = $user->createToken('MyApp')->accessToken;

                $userFirebase->update([
                    'token' => $success['token']
                ]);

                return Response()->json([
                    'code' => $this->successStatus,
                    'message' => 'کاربر کد را به درستی وارد کرده و ورود موفق',
                    'data' => $success,
                ]);

            } elseif ($request->code !== $userCode)

                return Response()->json([
                    'code' => $this->failedStatus,
                    'message' => 'کد صحیح نمی باشد',
                ]);
        }
        else {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => 'این شماره صحبح نمی باشد',
            ]);
        }
    }
}