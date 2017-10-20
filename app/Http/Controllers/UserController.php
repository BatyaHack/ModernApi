<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use JWTAuthException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use App\Http\Requests\registrationRequest;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index() {
        $admins = User::all();

        return $admins;
    }

    public function register(registrationRequest $request)
    {

//        $this->validate($request, [
//            'name' => 'required|min:8|max:16',
//            'password' => 'required|min:8|max:16',
//            'email' => 'required|email',
//        ]);

        $user = $this->user->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

        return response()->json(['status' => true, 'message' => 'User created successfully', 'data' => $user]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['invalid_email_or_password'], 422);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function getAuthUser(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
    }

    public function getAuthUserHeader(Request $request)
    {

        try {
            $header = $request->header('x-custom-token');
            $user = JWTAuth::toUser($header);
        } catch (TokenInvalidException $error) {
            $user = false;
        } catch (TokenExpiredException $error) {
            $user = false;
        } catch (JWTException $error) {
            $user = false;
        }


        return response()->json(['result' => $user]);

    }
}