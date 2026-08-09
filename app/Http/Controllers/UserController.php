<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return response()->json(User::all());
    }

    public function store( Request $request){
        $request -> validate([
            'name'        => 'required|string',
            'email'       => 'required|email|unique:users',
            'password'    => 'required|min:6',
            'role'        => 'required|in:admin,renter',
            'room_number' => 'nullable|string',
            'type'        => 'nullable|in:booking,pay_now',
            'tools'       => 'nullable|array',
            'tools.*'     => 'string',
            'photo'       => 'nullable|string|max:1400000',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'room_number' => $request->room_number,
            'type'        => $request->type,
            'tools'       => $request->tools ?? [],
            'photo'       => $request->photo,
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name'        => 'sometimes|required|string',
            'email'       => 'sometimes|required|email|unique:users,email,' . $user->id,
            'role'        => 'sometimes|required|in:admin,renter',
            'room_number' => 'nullable|string',
            'type'        => 'nullable|in:booking,pay_now',
            'tools'       => 'nullable|array',
            'tools.*'     => 'string',
            'photo'       => 'nullable|string|max:1400000',   // base64 string
        ]);

        $user->update($request->only([
            'name', 'email', 'role', 'room_number', 'type', 'tools', 'photo'
        ]));

        return response()->json($user);
    }

    public function updatetools(Request $request, User $user) {
        $request->validate(['tools' => 'required|array']);
        $user->update(['tools' => $request->tools]);
        return response()->json($user);
    }

    public function destroy(User $user) {
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

}
