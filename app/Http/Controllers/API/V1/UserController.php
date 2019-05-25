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
//        $validator = Validator::make($request->all(), [
//            'phone' => 'required'
//        ]);
//
//        if ($validator->fails()) {
//            $validate = collect($validator->errors());
//
//            return Response()->json(
//                [
//                    'code' => $this->failedStatus,
//                    'message' => $validate->collapse()[0]
//                ]);
//        }

        $phone = $request->phone;
        $device = $request->device;
        $user = User::where('phone', $phone)->first();

        if (!empty($user)) {
            $user_id = $user->id;
            $check_device = Firebase::where('user_id', $user_id)->where('device', $device)->first();
            if (!empty($check_device)) {

                return response()->json([
                    'code' => $this->successStatus,
                    'message' => 'کد برای شما ارسال شد!',
                ]);
            } else {
                return Response()->json([
                    'code' => $this->failedStatus,
                    'message' => 'خطای عدم دسترسی',
                ]);
            }

        } else {

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => 'خطای عدم دسترسی',
            ]);
        }
    }

    public function register(Request $request)
    {
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
                'message' => 'کد برای شما ارسال شد!',
            ]);

        } else {
            $user_id = $user->id;

            $check_devices = Firebase::where('device', $device)->first();

            if (!empty($check_devices)) {
                $check_devices->update(['code' => 3333]);

                return response()->json([
                    'code' => $this->successStatus,
                    'message' => 'کد برای شما ارسال شد!',
                ]);
            } else {
                Firebase::create([
                    'user_id' => $user_id,
                    'device' => $device,
                    'code' => 4444
                ]);

                return response()->json([
                    'code' => $this->successStatus,
                    'message' => 'کد برای شما ارسال شد!',
                ]);
            }
        }
    }

    public function verification(Request $request)
    {
        $phone = $request->phone;
        $code = $request->code;
        $device = $request->device;

        $user = User::where('phone', $phone)->first();

        $userID = $user->id;

        $userFirebase = Firebase::where('user_id', $userID)->where('device', $device)->first();

        $userCode = $userFirebase->code;
        $userDevice = $userFirebase->device;

        if ($code == $userCode && $device == $userDevice) {

            $success['token'] = $user->createToken('MyApp')->accessToken;

            $userFirebase->update([
                'token' => $success['token']
            ]);

            return Response()->json([
                'code' => $this->successStatus,
                'message' => 'ورود موفق',
                'data' => $success,
            ]);

        } else

            return Response()->json([
                'code' => $this->failedStatus,
                'message' => 'خطای عدم دسترسی',
            ]);
    }

    public function update(Request $request)
    {
        $name = $request->name;
        $phone = $request->phone;

        $user = User::where('phone', $phone)->first();

        if (empty($phone) && !empty($name)) {
            Auth::user()->update([
                'name' => $name,
            ]);

            return Response()->json([
                'code' => $this->successStatus,
                'message' => 'تغییرات نام انجام شد'
            ]);
        } elseif (!empty($phone) && empty($name)) {

            if (empty($user)) {

                Auth::user()->update([
                    'phone' => $phone,
                ]);
                $user_id = Auth::user()->id;
                $check_user = Firebase::where('user_id', $user_id)->first();

                $check_user->update([
                    'code' => '2222',
                ]);

                return Response()->json([
                    'code' => $this->successStatus,
                    'message' => ' کد برای شما ارسال شد',
                ]);
            }

        } elseif (!empty($phone) && !empty($name)) {

            if (empty($user)) {

                Auth::user()->update([
                    'name' => $name,
                    'phone' => $phone,
                ]);

                $user_id = Auth::user()->id;
                $check_user = Firebase::where('user_id', $user_id)->first();

                $check_user->update([
                    'code' => '1111',
                ]);

                return Response()->json([
                    'code' => $this->successStatus,
                    'message' => 'تغییرات شماره و نام انجام شد و کد ارسال شد',
                ]);
            }

        }
    }
}

