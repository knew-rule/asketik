<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();
        
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $users->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%")
                      ->orWhere('email', 'like', "%$searchTerm%");
            });
        }
        
       // Apply user type filter if selected
if ($request->filled('usertype')) { // Change 'user_type' to 'usertype'
    $userType = $request->input('usertype'); // Change 'user_type' to 'usertype'
    if ($userType === 'all') {
        // Don't filter by user type
    } else {
        $users->where('usertype', $userType);
    }
}

        
        $users = $users->get();
        
        $subPageTitle = 'FRESH AND ORGANIC';
        $pageTitle = 'User List';
        return view('ui.superadmin.user_index', compact('users',  'subPageTitle', 'pageTitle'));
    }
    
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $active = 'Shop';
        $subPageTitle = 'FRESH AND ORGANIC';
        $pageTitle = 'Shop';
        return view('ui.superadmin.user_show', compact('user',
        'active',
        'subPageTitle',
        'pageTitle'));
    }

    public function edit(User $user)
    {
        $active = 'Shop';
        $subPageTitle = 'FRESH AND ORGANIC';
        $pageTitle = 'Shop';
        return view('ui.superadmin.user_edit', compact('user',
        'active',
        'subPageTitle',
        'pageTitle'));
    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'password' => 'nullable|min:6',
        'usertype' => 'required|in:customer,admin', // Add validation for user type
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->usertype = $request->usertype; // Update user type

    if ($request->has('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'Failed to delete user.');
        }
    }
}
