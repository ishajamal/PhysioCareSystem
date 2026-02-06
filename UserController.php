<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display user list
    public function index()
    {
        $users = User::all();
        return view('admin.manageUser', compact('users'));
    }

    // Search user
    public function search(Request $request)
    {
        $users = User::where('name', 'like', '%' . $request->keyword . '%')
                     ->orWhere('email', 'like', '%' . $request->keyword . '%')
                     ->get();

        return view('admin.manageUser', compact('users'));
    }

    // Show add user form
    public function create()
    {
        return view('admin.addUser');
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'role'     => 'required',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'status'   => 'active',
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('manage.user')
                         ->with('success', 'User added successfully');
    }

    // Show edit form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.editUser', compact('user'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
            'role'  => 'required',
            'status'=> 'required'
        ]);

        $user = User::findOrFail($id);
        $user->name   = $request->name;
        $user->email  = $request->email;
        $user->role   = $request->role;
        $user->status = $request->status;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('manage.user')
                         ->with('success', 'User updated successfully');
    }

    // Delete user
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('manage.user')
                         ->with('success', 'User deleted successfully');
    }
}
