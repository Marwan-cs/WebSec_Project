<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::whereHas('roles', function ($query) {
            $query->where('slug', 'staff');
        })->paginate(10);
        return view('manager.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('manager.staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $staffRole = Role::where('slug', 'staff')->first();
        if ($staffRole) {
            $user->roles()->attach($staffRole);
        }

        return redirect()->route('manager.staff.index')->with('success', 'Staff created successfully.');
    }

    public function show($id)
    {
        $staff = User::findOrFail($id);
        return view('manager.staff.show', compact('staff'));
    }

    public function edit($id)
    {
        $staff = User::findOrFail($id);
        return view('manager.staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $staff->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $staff->name = $validated['name'];
        $staff->email = $validated['email'];
        if (!empty($validated['password'])) {
            $staff->password = Hash::make($validated['password']);
        }
        $staff->save();

        return redirect()->route('manager.staff.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        $staff->delete();
        return redirect()->route('manager.staff.index')->with('success', 'Staff deleted successfully.');
    }
} 