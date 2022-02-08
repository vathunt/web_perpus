<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
	public function showFormLogin()
	{
		if (Auth::check()) {
			return redirect('/panel/dashboard')->with('sukses', 'Anda Sudah Login');
		}
		return view('auth_login');
	}

	public function postLogin(Request $request)
	{
		$rules = [
			'username'	=> 'required|string',
			'password'	=> 'required|string'
		];

		$messages = [
			'username.required'	=> 'Username Harus Diisi',
			'username.string'	=> 'Username Harus Berupa String',
			'password.required'	=> 'Password Harus Diisi',
			'password.string'	=> 'Password Harus Berupa String'
		];

		$validator = Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput($request->all());
		}

		$data = [
			'username'	=> $request->input('username'),
			'password'	=> $request->input('password')
		];

		Auth::attempt($data);
		if (Auth::check()) {
			return redirect('/panel/dashboard')->with('sukses', 'Anda Berhasil Login');
		} else {
			return redirect()->back()->with('error', 'Periksa Kembali Email dan Password')->withInput($request->all());
		}
	}

	public function signout()
	{
		Auth::logout();
		Session::flush();
		// return redirect('../signin');
	}
}