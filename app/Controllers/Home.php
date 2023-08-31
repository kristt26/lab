<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (is_null(session()->get('is_login'))) return redirect()->to(base_url('auth'));
        if (session()->get('role')=='Mahasiswa' && session()->get('change')=='0') return redirect()->to(base_url('profile'));
        return view('home', ['title' => 'Home']);
    }
}
