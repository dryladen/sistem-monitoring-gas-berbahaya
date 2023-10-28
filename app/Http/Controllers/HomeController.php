<?php

namespace App\Http\Controllers;

use App\Models\DataGas;
use App\Models\OutputFuzzy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Halaman Login',
        );
        return view('index', $data);
    }
    public function home()
    {
        $data = array(
            'title' => 'Dashboard',
            'user' => Auth::user()->name,
        );
        return view('dashboard', $data);
    }

    public function riwayat_monitoring()
    {
        $data = array(
            'title' => 'Riwayat Monitoring',
            'user' => Auth::user()->name,
            'data_gas' => OutputFuzzy::all(),
        );
        return view('riwayat_monitoring', $data);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);
        $infoLogin = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($infoLogin)) {
            return redirect('/home');
        } else {
            return redirect('')->withErrors('Email dan Password tidak terdaftar')->withInput();
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
