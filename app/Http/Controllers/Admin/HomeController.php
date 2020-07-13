<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }
}
