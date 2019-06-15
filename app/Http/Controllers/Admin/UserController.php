<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserUpdateRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function dashboard()
    {
        return view('panel.dashboard');
    }

    public function index()
    {
        $users = User::all();
        return view('panel.users.index',compact('users'));
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
        return view('panel.users.edit',compact('user'));
    }

    public function update(UserUpdateRequest $request,User $user)
    {
        $user->update([
            'name'     => $request->input('name'),
            'phone'    => $request->input('phone'),
        ]);
        return redirect()->route('admin.users.index');
    }
}
