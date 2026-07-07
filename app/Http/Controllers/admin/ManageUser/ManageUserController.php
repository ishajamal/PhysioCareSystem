<?php 

namespace App\Http\Controllers\Admin\ManageUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ManageUserController extends Controller
{
    // Display user list + search
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::where('is_approved', 1)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('UserID', $search);
            })->paginate(10);

        return view('admin.ManageUser.manage-user', compact('users', 'search'));
    }

    // Show edit form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.ManageUser.edit-user', compact('user'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email:rfc',
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/',
                'unique:users,email,' . $id . ',userID',
            ],
            'role' => 'required'
        ], [
            'name.required'  => 'Please enter a name',
            'email.required' => 'Please enter an email address',
            'email.email'    => 'Enter valid email format',
            'email.regex'    => 'Enter valid email format',
            'email.unique'   => 'This email is already taken by another user',
            'role.required'  => 'Please select a role',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('admin.manage.user')
            ->with('success', 'User updated successfully');
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        \App\Models\MaintenanceRequest::where('submittedBy', $user->userID)->delete();
        
        \App\Models\UsageRecord::where('usedBy', $user->userID)->delete();

        $user->delete();

        return redirect()->route('admin.manage.user')
            ->with('success', 'User and all their history deleted permanently.');
    }
}