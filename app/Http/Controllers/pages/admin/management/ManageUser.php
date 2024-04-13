<?php

namespace App\Http\Controllers\pages\admin\management;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ManageUser extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $user = User::select('id','name','username','email')->get();
        return view('content.pages.admin.management.user.index-user', compact('user'));
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string|max:255|regex:/^[a-zA-Zs]+$/',
            'username' => 'required|string|max:30|min:6|unique:users,username|regex:/^[a-zA-Z0-9 ]+$/',
            'password' => 'required|string|max:20|min:8|regex:/^[a-zA-Z0-9 ]+$/',
            'email' => 'required|string|email|max:50',
            'payment_credential' => 'nullable|numeric|digits:6|regex:/^[0-9]+$/'
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
            
            return back()
                ->with('success','Successfully Add Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->makeHidden(['password', 'encrypt_view', 'payment_credential', 'created_at', 'updated_at']);
        $render = view('content.pages.admin.management.user.component.content-edit', compact('user'));
        return response()->json(['data' => $render->render()]);
    }

    public function update($id)
    {
        $user = User::findOrFail($id);

        if ($this->request->username == $user->username) {
            $validator = Validator::make($this->request->all(), [
                'name' => 'required|string|max:255|regex:/^[a-zA-Zs]+$/',
                'username' => 'required|string|max:30|min:6|regex:/^[a-zA-Z0-9 ]+$/',
                'email' => 'required|string|email|max:50',
                'payment_credential' => 'nullable|numeric|digits:6|regex:/^[0-9]+$/'
            ]);

        } else {
            $validator = Validator::make($this->request->all(), [
                'name' => 'required|string|max:255|regex:/^[a-zA-Zs]+$/',
                'username' => 'required|string|max:30|min:6|unique:users,username|regex:/^[a-zA-Z0-9 ]+$/',
                'email' => 'required|string|email|max:50',
                'payment_credential' => 'nullable|numeric|digits:6|regex:/^[0-9]+$/'
            ]);
        }

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }

        $validated = $validator->validated();

        try {
            $user->update([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'payment_credential' => bcrypt($validated['payment_credential'])
            ]);

            $user->save();

            return back()
                ->with('success','Successfully Edit Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }
}
