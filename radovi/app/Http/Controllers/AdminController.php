<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,nastavnik,student'
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Uloga promijenjena!');
    }
}

