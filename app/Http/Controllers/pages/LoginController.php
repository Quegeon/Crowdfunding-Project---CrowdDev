<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Company;
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
        // dd(Auth::guard('web')->check());
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
            return redirect()
                ->route('dashboard.company');

        } else {
            return back()
                ->with('error', 'Invalid Username or Password');
        }
    }

    public function logout()
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();        
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();  
        } else {
            Auth::guard('company')->logout();        
        }

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

    public function postregister_company()
    {
        $validator = Validator::make($this->request->all(), [
            'username' => 'required|string|max:30|min:6|regex:/^[a-zA-Z0-9 ]+$/',
            'password' => 'required|string|max:20|min:8|regex:/^[a-zA-Z0-9 ]+$/',
            'company_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9 ]+$/',
            'work_field' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9\s, ]+$/',
            'country' => 'required|string',
            'company_email' => 'required|string|email|max:50|unique:companies,company_email',
            'company_description' => 'nullable|string|max:255',
            'name' => 'required|string|max:255|regex:/^[a-zA-Zs ]+$/',
            'position' => 'required|string|max:50|regex:/^[a-zA-Zs ]+$/',
            'personal_email' => 'required|string|email|max:50'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        };

        $validated = $validator->validated();

        try {
            $company = new Company([
                'id' => Str::orderedUuid(),
                'username' => $validated['username'],
                'password' => bcrypt($validated['password']),
                'encrypt_view' => encrypt($validated['password']),
                'company_name' => $validated['company_name'],
                'work_field' => $validated['work_field'],
                'country' => $validated['country'],
                'company_email' => $validated['company_email'],
                'company_description' => $validated['company_description'],
                'name' => $validated['name'],
                'position' => $validated['position'],
                'personal_email' => $validated['personal_email']
            ]);

            $company->save();

            return redirect()
                ->route('login')
                ->with('success','Successfully Add Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }
}
