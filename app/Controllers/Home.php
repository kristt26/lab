<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (is_null(session()->get('is_login'))) return redirect()->to(base_url('auth'));
        return view('home', ['title' => 'Home']);
    }
}
