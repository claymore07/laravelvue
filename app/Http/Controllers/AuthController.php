<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Http\Resources\UserResource;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login', 'signup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        $captcha = request('captcha');

        if ($captcha === true) {

            if (!$token = auth()->attempt($credentials)) {

                return response()->json(['error' => 'Unauthorized'], 401);

            }
            if(auth()->user()->is_activated == 0){
                return response()->json(['error' => ' ثبت نام اولیه شما ابتدا باید توسط کارشناس پژوهشی تایید شود. منتظر تایید باشید.'], 406);
            }
            auth()->user()->last_login = auth()->user()->current_login? auth()->user()->current_login : Carbon::now();
            auth()->user()->current_login = Carbon::now();
            auth()->user()->ip_address=\Request::getClientIp();
            auth()->user()->save();
            return $this->respondWithToken($token);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    public function signup(SignupRequest $request){
        $captcha = $request->get('captcha');

        if($captcha === true ){
            $input = $request->all();
            $input['is_activated'] = 0;
            User::create($request->all());
            return $this->login($request);
        }
        return response()->json(['error' => 'Unauthorized'], 401);

    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
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
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource(auth()->user()),
            //'user_type' => auth()->user()->type,
        ]);
    }
    public function payload(){
        return auth()->payload();
    }
}
