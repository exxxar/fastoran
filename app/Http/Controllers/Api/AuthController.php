<?php

namespace App\Http\Controllers\Api;

use Allanvb\LaravelSemysms\Facades\SemySMS;
use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Notifications\SignupActivate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;


class AuthController extends Controller
{

    /**
     * Login user and create token
     *
     * @param  [string] name
     * @param  [string] phone
     * @param  [string] email
     * @param  [string] telegram_chat_id
     */
    public function signupTelegram(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|unique:users',
            'telegram_chat_id' => 'required',
        ]);

        $code = random_int(100000, 999999);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email ?? $request->phone . "@fastoran.com",
            'password' => bcrypt($code),
            'phone' => $request->phone,
            'active' => false,
            'auth_code' => $code,
            'telegram_chat_id' => $request->telegram_chat_id,
            'activation_token' => Str::random(60)
        ]);

        $user->save();

        SemySMS::sendOne([
            'to' => $request->phone,
            'text' => "You password and verify: $code"
        ]);

        return response()->json([
            'message' => 'Пользователь успешно создан!'
        ], 201);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'phone' => 'required|unique:users',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'active' => true,
            'telegram_chat_id' => $request->telegram_chat_id ?? null,
            'activation_token' => Str::random(60)
        ]);
        $user->save();

        $user->notify(new SignupActivate($user));

        return response()->json([
            'message' => 'Пользователь успешно создан!'
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        $credentials['active'] = 1;
        $credentials['deleted_at'] = null;

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Пользователь успешно вышел!'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Данный активационный тоукен не действителен!'
            ], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return $user;
    }

    public function sendSmsVerify(Request $request)
    {
        $phone = $request->get('phone');

        $user = User::where("phone", $phone)->first();

        if (is_null($user))
            return response()
                ->json([
                    "message" => "User not found",
                    "is_deliveryman" => false,
                    "status" => 404
                ]);

        $code = random_int(100000, 999999);

        $user->auth_code = $code;
        $user->save();

        SemySMS::sendOne([
            'to' => $phone,
            'text' => "You verify code:$code"
        ]);

        return response()
            ->json([
                "message" => "Success user found",
                "is_deliveryman" => false,
                "status" => 200
            ]);

    }

    public function checkVerifyUser(Request $request)
    {
        $code = $request->get("code");
        $phone = $request->get("phone");

        $user = User::where("phone", $phone)->first();

        if (is_null($user))
            return response()
                ->json([
                    "message" => "User not found",
                    "verify" => false,
                    "status" => 404
                ]);

        if ($user->auth_code !== $code)
            return response()
                ->json([
                    "message" => "Bad code",
                    "verify" => false,
                    "status" => 400
                ]);

        $user->auth_code = null;
        $user->active = true;
        $user->save();

        return response()
            ->json([
                "message" => "Success",
                "verify" => true,
                "status" => 200
            ]);

    }

    public function checkUserExist(Request $request, $type)
    {
        $value = $request->get("value");

        $types = ["telegram_chat_id", "phone"];

        $key = count($types) - 1 > $type ? $types[0] : $types[$type];

        $user = User::where($key, $value)->first();

        if (is_null($user))
            return response()
                ->json([
                    "message" => "User not found by $key",
                    "is_deliveryman" => false,
                    "verify" => false,
                    "status" => 404
                ]);

        return response()
            ->json([
                "message" => "Success user found",
                "is_deliveryman" => $user->user_type === UserTypeEnum::Deliveryman,
                "verify"=>$user->active,
                "status" => 200
            ]);
    }

}
