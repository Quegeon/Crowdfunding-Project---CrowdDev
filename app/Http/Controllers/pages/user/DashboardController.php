<?php

namespace App\Http\Controllers\pages\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('content.pages.user.dashboard');
    }
}