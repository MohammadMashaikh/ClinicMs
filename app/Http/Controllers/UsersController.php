<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{

    public function index()
    {
        return view('admin.users.index');
    }


    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'second_name' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'role' => 'required|string',
            'gender' => 'required|string'
        ]);

        $full_name = $validatedData['first_name'] . ' ' . $validatedData['second_name'];
        $password = Hash::make($validatedData['password']);

        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'second_name' => $validatedData['second_name'],
            'full_name' => $full_name,
            'password' => $password,
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'gender' => $validatedData['gender'],
        ]);


        $user->assignRole($validatedData['role']);


        return redirect()->route('users.list')->with('success', 'User Created Successfully');

    }
}
