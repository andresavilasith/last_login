<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $idCurrentUser = auth()->user()->id;

        $currentUser = User::findOrFail($idCurrentUser);

        $currentDatetime = Carbon::now();

        $currentUser->last_login_date = $currentDatetime;

        $currentUser->update();

        return $this->respondWithToken($token);
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
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function register(AuthRegisterRequest $request)
    {
        $authRequest = $request->validated();

        if ($request->hasFile('image')) {
            $authRequest['image'] = $request->file('image')->store('users', 'public');
        }

        $user = User::create($authRequest);

        return response()->json([
            'status' => 'success',
            'user' => $user
        ], 201);
    }

    public function users()
    {
        $users = User::all();

        return response()->json([
            'users' => $users
        ]);
    }
}
