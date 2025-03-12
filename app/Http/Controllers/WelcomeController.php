<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Welcome',
            'list' => ['Home', 'Welcome']
        ];
        $activeMenu = 'dashboard';
        return view('welcome',['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);

        // You can return or use $breadcrumbs here
    }
}