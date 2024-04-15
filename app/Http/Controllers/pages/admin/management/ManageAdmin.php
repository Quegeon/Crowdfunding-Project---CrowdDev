<?php

namespace App\Http\Controllers\pages\admin\management;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ManageAdmin extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $admin = Admin::select('id','name','username','email')->get();
        return view('content.pages.admin.management.admin.index-admin', compact(['admin']));
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string|max:255|regex:/^[a-zA-Zs ]+$/',
            'username' => 'required|string|max:30|min:6|unique:admins,username|regex:/^[a-zA-Z0-9 ]+$/',
            'password' => 'required|string|max:20|min:8|regex:/^[a-zA-Z0-9]+$/',
            'email' => 'required|string|email|max:50'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        try {
            $admin = new Admin([
                'id' => Str::orderedUuid(),
                'name' => $validated['name'],
                'username' => $validated['username'],
                'password' => bcrypt($validated['password']),
                'encrypt_view' => encrypt($validated['password']),
                'email' => $validated['email']
            ]);

            $admin->save();

            return back()
                ->with('success','Successfully Add Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }

    }

    public function show($id)
    {
        $admin = Admin::findOrFail($id, ['id','name','username','email']);
        $render = view('content.pages.admin.management.admin.component.content-edit', compact(['admin']));
        return response()->json(['data' => $render->render()]);
    }

    public function update($id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->username === $this->request->username) {
            $validator = Validator::make($this->request->all(), [
                'name' => 'required|string|max:255|regex:/^[a-zA-Zs ]+$/',
                'username' => 'required|string|max:30|min:6|regex:/^[a-zA-Z0-9 ]+$/',
                'email' => 'required|string|email|max:50'
            ]);

        } else {
            $validator = Validator::make($this->request->all(), [
                'name' => 'required|string|max:255|regex:/^[a-zA-Zs ]+$/',
                'username' => 'required|string|max:30|min:6|unique:admins,username|regex:/^[a-zA-Z0-9 ]+$/',
                'email' => 'required|string|email|max:50'
            ]);
        }

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }

        $validated = $validator->validated();

        try {
            $admin->update([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email']
            ]);

            $admin->save();

            return back()
                ->with('success','Successfully Edit Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        try {
            $admin->delete();

            return back()
                ->with('success', 'Successfully Delete Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function show_password($id)
    {
        $dataId = Admin::findOrFail($id, ['id']);
        $render = view('content.pages.admin.management.admin.component.content-change-password', compact('dataId'));
        return response()->json(['data' => $render->render()]);
    }

    public function visibility_password($id)
    {
        $encrypt = Admin::findOrFail($id, ['encrypt_view']);
        $decrypt = decrypt($encrypt->encrypt_view);
        return response()->json(['data' => $decrypt]);
    }

    public function update_password($id)
    {
        $admin = Admin::findOrFail($id);

        $validator = Validator::make($this->request->all(), [
            'new_password' => 'required|string|max:20|min:8|regex:/^[a-zA-Z0-9]+$/'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        };

        $validated = $validator->validated();

        try {
            $admin->update([
                'password' => bcrypt($validated['new_password']),
                'encrypt_view' => encrypt($validated['new_password'])
            ]);
            
            $admin->save();

            return back()
                ->with('success', 'Successfully Change Password');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }
}
