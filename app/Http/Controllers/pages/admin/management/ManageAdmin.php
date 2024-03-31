<?php

namespace App\Http\Controllers\pages\admin\management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageAdmin extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return view('content.pages.admin.management.admin.index-admin');
    }

    public function store()
    {
        $validated = $this->request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Zs]+$/',
            'username' => 'required|string|max:30|min:6|regex:/^[a-zA-Z0-9 ]+$/',
            
        ]);
    }
}
