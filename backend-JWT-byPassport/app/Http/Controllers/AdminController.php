<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return response()->json($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|max:255',
        ], [
            'name.required' => 'You did not input your name',
            'name.min' => 'Name at least 4 character',
            'email.required' => 'You did not input your email!',
            'email.email' => 'You should input EMAIL',
            'email.unique' => 'This email was exist',
            'password.required' => 'You did not input password!',
            'password.min' => 'password at least 4 character!',
            'password.max' => 'password maximum 25 character!',
        ]);

        $user = new User;
        $role = Role::findById(1);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->assignRole($role);
        $user->save();
        return response()->json([
            'success' => 'Create user successfully!',
            'User' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {   
        return response()->json($user);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:4|max:255',
        ], [
            'name.required' => 'You did not input your name',
            'name.min' => 'Name at least 4 character',
            'email.required' => 'You did not input your email!',
            'email.email' => 'You should input EMAIL',
            'password.required' => 'You did not input password!',
            'password.min' => 'password at least 4 character!',
            'password.max' => 'password maximum 25 character!',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'success' => 'Update user successfully!',
            'User' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => 'Deleted user!'
        ]);
    }
}
