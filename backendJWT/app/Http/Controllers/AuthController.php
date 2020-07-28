<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use App\User;
use App\Todo;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(RegisterRequest $request){
        
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'success' => 'Register successfully!',
            'User' => $user
        ]);
    }
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        Log::channel('info_user_history')->info('Showing user profile for user: ' . auth()->user());
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * get all Todo this user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTodo(){
        return $this->respondWithTodoByUserId(auth()->user()->id);
    }
    /**
     * Create a todo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTodo(CreateTodoRequest $request){
        $todo = new Todo;
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->user_id = auth()->user()->id;
        $todo->save();
        return response()->json($todo);
    }
    /**
     * Delete a todo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTodo(Todo $todo){
        $todo->delete();
        return response()->json($todo);
    }
    /**
     * Edit todo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editTodo(CreateTodoRequest $request,Todo $todo){
        if($todo->user_id != auth()->user()->id)
            return response()->json(['message' => 'edit failed! Can not edit todo other user!']);
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->save();
        return response()->json([
            'message' => 'Update Todo success!',
            'todo' => $todo
        ]);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    protected function respondWithTodoByUserId($userId){
        return response()->json(Todo::where('user_id', $userId)->get());
    }
}