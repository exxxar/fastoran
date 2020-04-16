<?php

namespace App\Http\Controllers\Api;

use App\Classes\Utilits;
use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Notifications\SignupActivate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    use Utilits;

    public function signupTelegram(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required',
            'telegram_chat_id' => 'required',
        ]);

        $this->doHttpRequest(
            env('APP_URL') . '/api/v1/auth/signup', [
            'name' => $request->name,
            'phone' => $request->phone,
            'telegram_chat_id' => $request->telegram_chat_id
        ]);
    }

    public function signupPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|unique:users',
            'name' => 'nullable|string',
            'telegram_chat_id' => 'nullable|string'
        ]);


        return $this->doHttpRequest(
            env('APP_URL') . 'api/v1/auth/signup', [
            'name' => $request->name,
            'phone' => $request->phone,
            'telegram_chat_id' => $request->telegram_chat_id

        ]);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'phone' => 'required|unique:users',
            'name' => 'nullable|string',
            'telegram_chat_id' => 'nullable|string'
        ]);

        $code = random_int(100000, 999999);

        $user = new User([
            'name' => $request->name ?? '',
            'email' => $request->email ?? $request->phone . "@fastoran.com",
            'password' => bcrypt($code),
            'phone' => $request->phone,
            'active' => false,
            'auth_code' => $code,
            'telegram_chat_id' => $request->telegram_chat_id,
            'activation_token' => Str::random(60)
        ]);

        $user->save();

        // $this->sendSms($user->phone, "Ваш пароль для доступа к ресурсу https://fastoran.com: " . $code);

        return response()->json([
            'message' => 'Пользователь успешно создан! СМС с паролем доступа к ресурсу придет в течении нескольких минут!'
        ], 201);
    }

    public function loginPhone(Request $request)
    {
        $this->doHttpRequest(
            env('APP_URL') . '/api/v1/auth/login', [
            'phone' => $request->phone,
            'password' => $request->password,
            'remember_me' => $request->remember_me ?? 0
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['phone', 'password']);
        $credentials['active'] = 1;
        $credentials['deleted_at'] = null;

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Ошибка авторизации'
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

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Пользователь успешно вышел!'
        ]);
    }

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
        $phone = $this->preparePhone($request->get('phone'));

        $user = User::where("phone", $phone)->first();

        try {
            $code = random_int(100000, 999999);
        } catch (\Exception $e) {
            Log::error(sprintf("%s:%s %s",
                $e->getLine(),
                $e->getFile(),
                $e->getMessage()
            ));
        }

        $user->auth_code = $code;
        $user->save();

        $this->sendSms($phone, "Ваш пароль для доступа к ресурсу https://fastoran.com: " . $code);

        if (!is_null($user))
            return response()
                ->json([
                    "message" => !is_null($user->auth_code) ?
                        "Введите предыдущий код из СМС!" :
                        "На ваш номер отправлен СМС с кодом!"
                ], 200);

        return response()
            ->json([
                "message" => "На ваш номер отправлен СМС с кодом!"
            ], 200);


    }

    public function checkVerifyUser(Request $request)
    {
        $code = $request->get("code");
        $phone = $request->get("phone");

        $user = User::where("phone", $phone)->first();

        $validator = Validator::make(
            [
                "user" => $user
            ],
            [
                'user' => [
                    'required',
                    function ($attribute, $value, $fail) use ($code) {
                        if ($value->auth_code !== $code) {
                            $fail('Плохой верификационный код');
                        }
                    },
                ]
            ],
            [
                'user.required' => 'Пользователь не найден',
            ]);

        if ($validator->fails())
            return response()
                ->json(
                    $validator->errors()->toArray(), 500
                );

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
                "verify" => $user->active == true,
                "status" => 200
            ]);
    }

}
