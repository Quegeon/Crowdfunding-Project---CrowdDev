<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.login', ['pageConfigs' => $pageConfigs]);
    }

    public function postlogin()
    {
        $validator = Validator::make($this->request->all(), [
            'email' => 'required|email|max:50',
            'password' => 'required|string|max:20|min:8|regex:/^[a-zA-Z0-9]+$/'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        };

        $validated = $validator->validated();

        if (Auth::attempt($this->request->only('email','password'))) {
            return redirect()
                ->route('dashboard.user');

        } elseif (Auth::guard('admin')->attempt($this->request->only('email','password'))) {
            return redirect()
                ->route('dashboard.admin');

        } elseif (Auth::guard('company')->attempt(['company_email' => $validated['email'], 'password' => $validated['password']])) {
            dd('company');

        } else {
            return back()
                ->with('error', 'Invalid Username or Password');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()
            ->route('login');
    }
}
