<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request) {
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL) == FALSE) {
            return [
                'username' => $request->email,
                'password' => $request->password
            ];
        }
        return $request->only('email', 'password');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) { // $credentials = request(['email', 'password']);
        $credentials = $this->credentials($request);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        activity()->causedBy(auth()->user())->withProperties([
            'icon'  => 'fa fa-sign-in text-success',
            'ip'    => $request->ip()
        ])->log('Đăng nhập thành công');

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        $user = User::findOrFail(auth()->user()->id);
        return response()->json(new UserResource($user), 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
        activity()->causedBy(auth()->user())->withProperties([
            'icon'  => 'fa fa-sign-out text-success',
            'ip'    => $request->ip()
        ])->log('Đăng xuất thành công');

        auth()->logout();

        return response()->json(['message' => 'Đăng xuất thành công!']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
