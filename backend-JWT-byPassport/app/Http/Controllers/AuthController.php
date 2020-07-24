<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function login(Request $request){
        $http = new \GuzzleHttp\Client;

        try{
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->email,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody();
        } catch(\GuzzleHttp\Exception\BadResponseException $e){
            if($e->getCode() === 400){
                return response()->json(
                    'Invalid Request. Please enter a email or password!', $e->getCode()
                );
            } else if($e->getCode() === 401){
                echo($request->email);
                return response()->json(
                    'Your credentials are incorrect. Please try again', $e->getCode()
                );
            }
            return response()->json(
                'Something went wrong with server. Please try again!', $e->getCode()
            );
        }

        
    }

    public function register(Request $request){
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
        $role = Role::findById(1);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->assignRole($role);
        $user->save();
        return response()->json([
            'success' => 'Register successfully!',
            'User' => $user
        ]);
    }

    public function logout(){
        auth()->user()->tokens->each(function ($token, $key){
            $token->delete();
        });
        return response()->json([
            'message' => 'Logout successfully!'
        ]);
    }
}
