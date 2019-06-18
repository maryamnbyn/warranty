<?php

namespace App\Http\Controllers\Admin;


use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\adminUpdateRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{

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
