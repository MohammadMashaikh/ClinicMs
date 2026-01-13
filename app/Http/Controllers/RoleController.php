<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    


    public function list()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('roles.index', compact('roles'));
    }


    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create([
            'name' => $validatedData['name']
        ]);


        $role->permissions()->sync($validatedData['permissions']);


       return redirect()->route('role.list')->with('success', 'Role created successfully.');
    }



    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }



    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::findOrFail($id);

        $role->update([
            'name' => $validatedData['name']
        ]);

        $role->permissions()->sync($validatedData['permissions']);


       return redirect()->route('role.list')->with('success', 'Role Updated successfully.');
    }




    public function delete(Role $role)
    {
        $user = auth()->user();

        if (!$user->hasRole('super-admin')) {
            return redirect()->back()->with('error', 'Only Super Admin Can Delete Roles');
        }

        $role->delete();
        return redirect()->back()->with('success', 'Role ' . $role->name . ' Deleted Successfully');
    }
}
