<?php

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function __construct()
    {
        //
    }

    public function createUser(UserRequest $request)
    {
        try {
            $user = User::create([
                'first_name' => $request['first_name'],
                'admin_id' => Auth::id(),
                'role' => $request['role'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'birth_date' => $request['birth_date'],
                'password' => Hash::make($request['password']),
            ]);
            return $user;
            // }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create user.'], 500);
        }
    }

    public function login(Request $request) 
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return $user = Auth::user();
        } else {
            // Authentication failed, return null
            return null;
        }
    }

    public function getAllUsersMembers()
    {

        $currentUser = Auth::user();

        $filteredUsers = User::where('role', 1)
            ->orWhere('admin_id', $currentUser->admin_id)
            ->simplePaginate(5);

        $memberUser = $filteredUsers->map(function ($user) {
            return [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'password' => $user->password,
                'birth_date' => $user->birth_date,
                'age' => Carbon::parse($user->birth_date)->age,
                'role' => $user->role,
            ];
        });

        return [
            'users' => $memberUser,
            'paginator' => $filteredUsers,
        ];
    }
    public function getAllUsersAdmin()
    {

        $currentUser = Auth::user();

        $filteredUsers = User::where('role', 2)
            ->orWhere('admin_id', $currentUser->id)
            ->simplePaginate(5);

        $memberUser = $filteredUsers->map(function ($user) {
            return [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'password' => $user->password,
                'birth_date' => $user->birth_date,
                'age' => Carbon::parse($user->birth_date)->age,
                'role' => $user->role,
            ];
        });

        return [
            'users' => $memberUser,
            'paginator' => $filteredUsers,
        ];
    }

    public function getAllForMembers()
    {
        $users = User::all();

        $userAsMembers = $users->map(function ($users) {
            return [
                'id' => $users->id,
                'first_name' => $users->first_name,
                'last_name' => $users->last_name,
                'email' => $users->email,
                'password' => $users->password,
                'birth_date' => $users->birth_date,
                'age' => Carbon::parse($users->birth_date)->age,
                'role' => $users->role,
            ];
        });

        return $users;
    }

    public function editUser(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'role' => 'required',
            'email' => 'required|string|email|max:255',
            'birth_date' => 'sometimes|nullable|date',
            'password' => 'required|string|min:6',
        ]);

        $user = User::findOrFail($request->input('id'));
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->role = $validated['role'];
        $user->email = $validated['email'];
        $user->birth_date = $validated['birth_date'];
        $user->password = Hash::make($validated['password']);
        $user->save();
        return redirect('dashboard')->with('success', 'User updated successfully');
    }

    public function deleteUser(Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        $user->delete();
        return redirect('dashboard')->with('success', 'User deleted successfully');
    }

}
