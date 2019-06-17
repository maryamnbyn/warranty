<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserUpdateRequest;
use App\User;
use Carbon\Carbon;
use ConsoleTVs\Charts\Facades\Charts;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
        $users = User::all();
        return view('panel.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if ($user != null) {
            $user->delete();
            return redirect()->back();
        }
    }

    public function edit(User $user)
    {
        return view('panel.users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
        ]);
        return redirect()->route('admin.users.index');
    }
}
