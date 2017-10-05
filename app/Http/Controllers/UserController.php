<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Admin;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() {
        $name_column = \Schema::getColumnListing('users');;
        $all_users = User::all();
        $admin = Auth::check();
        $user = Auth::user();
        return response()->json([
            $all_users,
            'columns' => $name_column,
            'admin' => $admin, // пока у нас все пользователи админы
            'userReg' => $user,
        ], 200);
    }

    public function admins() {
        return Admin::all();
    }

    public function show(User $user) {
        return $user;
    }

    public function store(Request $request) {
        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user) {
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete(User $user) {
        $user->delete();

        return response()->json(null, 200);
    }
}
