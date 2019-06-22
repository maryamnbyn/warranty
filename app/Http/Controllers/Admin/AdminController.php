<?php

namespace App\Http\Controllers\Admin;


use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\adminUpdateRequest;
use App\User;
use Carbon\Carbon;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard()
    {
        $last_year = Carbon::now()->subMonth(12);

        $users = User::where('created_at', '>', $last_year)->selectRaw('COUNT(*) as count, YEAR(created_at) year, MONTH(created_at) month')
            ->groupBy('year', 'month')
            ->get();

        if ($users->first() != null) {

            $i = 0;

            foreach ($users as $user) {

                $count[$i] = $user->count;

                switch ($user->month) {
                    case    '1':
                        $month[$i] = 'دی ';
                        break;
                    case    '2':
                        $month[$i] = 'بهمن ';
                        break;
                    case    '3':
                        $month[$i] = 'اسفند ';
                        break;
                    case    '4':
                        $month[$i] = 'فروردین ';
                        break;
                    case    '5':
                        $month[$i] = 'اریبهشت';
                        break;
                    case    '6':
                        $month[$i] = 'خرداد ';
                        break;
                    case    '7':
                        $month[$i] = 'تیر ';
                        break;
                    case    '8':
                        $month[$i] = 'مرداد ';
                        break;
                    case    '9':
                        $month[$i] = 'شهریور ';
                        break;

                    case    '10':
                        $month[$i] = 'مهر ';
                        break;
                    case    '11':
                        $month[$i] = 'آبان ';
                        break;
                    case    '12':
                        $month[$i] = 'آذر ';
                        break;
                }
                $i++;

            }

            $chart = Charts::create('line', 'highcharts')
                ->title('نمودار نمایش کاربران')
                ->elementLabel('نمودار نمایش کاربران')
                ->labels($month)
                ->values($count)
                ->dimensions(1000, 500)
                ->responsive(false);

            return view('panel.dashboard', ['chart' => $chart]);
        }

        $chart = Charts::create('line', 'highcharts')
            ->title('نمودار نمایش کاربران')
            ->elementLabel('نمودار نمایش کاربران')
            ->labels(['فروردی' , 'اردیبهشت' , 'خرداد' ,' تیر' ,'مرداد' ,'شهریور' ,'مهر' ,'آبان' ,'آذر' , 'دی' ,'بهمن' ,'اسفند'])
            ->values([0,0,0,0,0,0,0,0,0,0,0,0])
            ->dimensions(1000, 500)
            ->responsive(false);

        return view('panel.dashboard', ['chart' => $chart]);
    }


    public function index()
    {
        return view('panel.admin.index', compact('admins'));
    }
    public function Profile()
    {
        $admins = Admin::all();
        return view('panel.admin.profile', compact('admins'));
    }

    public function update(adminUpdateRequest $request,$id)
    {
        $admin = Admin::where('id',$id)->first();
        $admin->update([
            'name'     => $request->name,
            'family'   => $request->family,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'role' =>'admin',
            'password' => bcrypt($request->password),
        ]);
        return redirect()->back();
    }
}
