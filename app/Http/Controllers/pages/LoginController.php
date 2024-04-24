<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

    public function register()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.register', ['pageConfigs' => $pageConfigs]);
    }

    public function postregister()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string|max:255|regex:/^[a-zA-Zs ]+$/',
            'username' => 'required|string|max:30|min:6|regex:/^[a-zA-Z0-9 ]+$/',
            'password' => 'required|string|max:20|min:8|regex:/^[a-zA-Z0-9 ]+$/',
            'email' => 'required|string|email|max:50|unique:users,email',
            'payment_credential' => 'required|numeric|digits:6|regex:/^[0-9]+$/'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        };

        $validated = $validator->validated();

        try {
            $user = new User([
                'id' => Str::orderedUuid(),
                'name' => $validated['name'],
                'username' => $validated['username'],
                'password' => bcrypt($validated['password']),
                'encrypt_view' => encrypt($validated['password']),
                'email' => $validated['email'],
                'payment_credential' => bcrypt($validated['payment_credential'])
            ]);

            $user->save();
            
            return redirect()
                ->route('login')
                ->with('success','Successfully Add Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function register_company()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.register-company', ['pageConfigs' => $pageConfigs]);
    }
}
