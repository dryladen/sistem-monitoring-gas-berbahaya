<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Data User',
            'data_user' => User::all(),
            'user' => Auth::user()->name,'user-login' => Auth::user()->name,
        );
        return view('user', $data);
    }
    
    public function profile(){
        $user = Auth::user();
        
        $data = array(
            'title' => 'Profile',
            'user' => Auth::user()->name,
            'data_profile' => User::where('id',$user->id)->get(),
        );
        
        return view('profile', $data);
    }
    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'email' => 'email',
        //     'password' => 'required|confirm|min:3'
        // ]);
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);
        return redirect('user')->with('success', 'Data Berhasil Disimpan');
    }
    public function update(Request $request, $id)
    {
        User::where('id', $id)->where('id', $id)->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);
        return redirect('user')->with('success', 'Data Berhasil Diubah');
    }
    public function updateProfile(Request $request, $id)
    {
        User::where('id', $id)->where('id', $id)->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);
        return redirect('profile')->with('success', 'Data Berhasil Diubah');
    }
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect('user')->with('success', 'Data Berhasil Dihapus');
    }
}
