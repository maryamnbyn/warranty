<?php

namespace App\Http\Controllers\API\V1;

use App\User;
use Validator;
use App\Firebase;
use http\Env\Response;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Else_;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\SyslogUdp\UdpSocket;


class UserController extends Controller
{
    private $successStatus = 1;
    private $failedStatus = -1;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
        $device = $request->device;
        $user = User::where('phone', $phone)->first();

        if (!empty($user)) {
            $user_id = $user->id;
            $check_device = Firebase::where('user_id', $user_id)->where('device', $device)->first();

            if (!empty($check_device)) {
                $check_device->update([
                    'code' => 8888
                ]);

                return response()->json([
                    'code' => $this->successStatus,
                    'message' => 'کاربر وجود داشته و کد جدید برایش ارسال شد!',
                ]);
            } else {
                Firebase::create([
                    'user_id' => $user_id,
                    'device' => $device,
                    'code' => 4444
                ]);

                return Response()->json([
                    'code' => $this->successStatus,
                    'message' => 'کاربر با این وسیله ثبت و کد ارسال شد!',
                ]);
            }

        } else {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => 'کاربری با این شماره وجود نداشته و خطای عدم دسترسی',
            ]);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'regex:/^[a-zA-Z]+$/u|max:12',
            'phone' => 'max:11',
        ]);

        if ($validator->fails()) {
            $validate = collect($validator->errors());

            return Response()->json(
                [
                    'code' => $this->failedStatus,
                    'message' => $validate->collapse()[0]
                ]);
        }

        $name = $request->name;
        $phone = $request->phone;
        $device = $request->device;

        $user = User::where('phone', $phone)->first();

        if (empty($user)) {

            $user = User::create([
                'name' => $name,
                'phone' => $phone,
            ]);

            $user_id = $user->id;

            Firebase::create([
                'user_id' => $user_id,
                'device' => $device,
                'code' => 4444
            ]);

            return response()->json([
                'code' => $this->successStatus,
                'message' => 'کاربر جدید بوده و کد برایش ارسال شد!',
            ]);

        } else {
            return response()->json([
                'code' => $this->failedStatus,
                'message' => 'کاربر جدید نیست و باید لاگین کند!',
            ]);
        }
    }

    public function verification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:4',

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
        $code = $request->code;
        $device = $request->device;

        $user = User::where('phone', $phone)->first();

        $userID = $user->id;

        $userFirebase = Firebase::where('user_id', $userID)->where('device', $device)->first();

        $userCode = $userFirebase->code;

        if ($code == $userCode) {

            $success['token'] = $user->createToken('MyApp')->accessToken;

            $userFirebase->update([
                'token' => $success['token']
            ]);

            return Response()->json([
                'code' => $this->successStatus,
                'message' => 'کاربر کد را به درستی وارد کرده و ورود موفق',
                'data' => $success,
            ]);

        } elseif ($code !== $userCode)

            $userFirebase->delete();

        return Response()->json([
            'code' => $this->failedStatus,
            'message' => 'کاربر کد را به درستی وارد نکرده و خطای عدم دسترسی ',
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'regex:/^[a-zA-Z]+$/u|max:12',

        ]);

        if ($validator->fails()) {
            $validate = collect($validator->errors());

            return Response()->json(
                [
                    'code' => $this->failedStatus,
                    'message' => $validate->collapse()[0]
                ]);
        }

        $name = $request->name;
        $phone = $request->phone;

        if (empty($phone)) {
            Auth::user()->update([
                'name' => $name
            ]);

            return Response()->json([
                'code' => $this->successStatus,
                'message' => 'تغییر نام انجام شد',
            ]);
        } else {

            $user = User::where('phone', $phone)->first();

            if (!empty($user)) {

                return Response()->json([
                    'code' => $this->failedStatus,
                    'message' => 'این شماره قبلا ثبت شده است وخطای عدم دسترسی',
                ]);
            } else {

                $user_id = Auth::user()->id;
                $check_device = Firebase::where('user_id', $user_id)->first();
                $check_device->update([
                    'code' => 2525
                ]);

                return Response()->json([
                    'code' => $this->successStatus,
                    'message' => 'کد برای شما ارسال شد',
                ]);
            }
        }

    }

    public function verificationUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'regex:/^[a-zA-Z]+$/u|max:12',
            'phone' => 'required',
            'device' => 'required',
            'code' => 'required|max:4',

        ]);

        if ($validator->fails()) {
            $validate = collect($validator->errors());

            return Response()->json(
                [
                    'code' => $this->failedStatus,
                    'message' => $validate->collapse()[0]
                ]);
        }

        $name = $request->name;
        $phone = $request->phone;
        $device = $request->device;
        $code = $request->code;

        $user_id = Auth::user()->id;

        $check_device = Firebase::where('user_id', $user_id)->where('device', $device)->first();
        $user_code = $check_device['code'];

        if ($code == $user_code) {

            $success['token'] = Auth::user()->createToken('MyApp')->accessToken;

            if (empty($name)) {
                $check_device->update([
                    'token' => $success['token']
                ]);

                Auth::user()->update([
                    'phone' => $phone
                ]);

                return Response()->json([
                    'code' => $this->successStatus,
                    'message' => 'تغییرات شماره انجام شد',
                    'token' => $success
                ]);
            } else {
                $check_device->update([
                    'token' => $success['token']
                ]);

                Auth::user()->update([
                    'name' => $name,
                    'phone' => $phone
                ]);

                return Response()->json([
                    'code' => $this->successStatus,
                    'message' => 'تغییرات نام و شماره انجام شد',
                    'token' => $success
                ]);
            }
        }

    }

    public function logout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
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

        $token = $request->token;
        $device = $request->device;

        $user = Firebase::where('token', $token)->where('device', $device)->first();
        $user->delete();

        return Response()->json([
            'code' => $this->successStatus,
            'message' => 'کاربر با موفقیت حذف شد',
        ]);
    }
}

