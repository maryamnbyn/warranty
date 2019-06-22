<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Requests\UserUpdateRequest;
use App\Product;
use App\User;
use Carbon\Carbon;
use ConsoleTVs\Charts\Facades\Charts;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function showProfile(User $user)
    {
       $products = Product::where('user_id' ,$user->id)->get();

        return view('panel.users.profile', compact('products','user'));
    }


    public function index()
    {
        $users = User::paginate(config('page.paginate_page'));
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
