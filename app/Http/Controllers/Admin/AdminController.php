<?php

namespace App\Http\Controllers\Admin;


use App\Admin;
use App\Events\MessageCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\adminUpdateRequest;
use App\User;
use Carbon\Carbon;
use ConsoleTVs\Charts\Facades\Charts;
use Morilog\Jalali\CalendarUtils;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function sendMessage(User $user)
    {
        return view('panel.admin.sendMessage',compact('user'));
    }

    public function sendUserMessage(Request $request,User $user)
    {

        event(new MessageCreated($request->message,$user->phone));

        return back();
    }

    public function dashboard()
    {
        $last_year = Carbon::now()->subMonth(12);

        $users = User::where('created_at', '>', $last_year)->selectRaw('COUNT(*) as count, YEAR(created_at) year, MONTH(created_at) month')
            ->groupBy('year', 'month')
            ->get();

        if ($users->first() != null) {

            $i = 0;

            foreach ($users as $user) {

                $date = [$user->year, $user->month, 1];

                $month[$i] = CalendarUtils::strftime('y F', strtotime(join('-', $date)));

                $count[$i] = $user->count;

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
            ->labels(['فروردی', 'اردیبهشت', 'خرداد', ' تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'])
            ->values([0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0])
            ->dimensions(1000, 500)
            ->responsive(false);

        return view('panel.dashboard', ['chart' => $chart]);
    }


    public function index()
    {
        return redirect('/login');
//        return view('panel.admin.index', compact('admins'));
    }

    public function Profile()
    {
        $admins = Admin::all();

        return view('panel.admin.profile', compact('admins'));
    }

    public function update(adminUpdateRequest $request, $id)
    {
        $admin = Admin::where('id', $id)->first();

        $admin->update([
            'name' => $request->name,
            'family' => $request->family,
            'phone' => $request->phone,
            'email' => $request->email,
            'role' => 'admin',
            'password' => bcrypt($request->password),
        ]);
        return redirect()->back();
    }
}


