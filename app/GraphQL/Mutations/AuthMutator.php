<?php

namespace App\GraphQL\Mutations;

use App\Events\UserRegistredEvent;
use App\User;
use App\Verification;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;


class AuthMutator
{

    public function login($root, array $args)
    {
        $credentials = Arr::only($args, ['phone', 'password']);
        try {
            if ($token = JWTAuth::attempt($credentials, ['exp' => Carbon::now()->addYear(3)->timestamp])) {
                return $token;
            }
        } catch (JWTException $e) {
            return null;
        }
        return null;
    }

    public function register($root, array $args)
    {
        $user = User::create([
            'phone' => $args['phone'],
            'name' => $args['name'],
            'family' => $args['family'],
            'password' => $args['password'],
        ]);
        $user = User::find($user->id);
        $token = auth()->login($user);
        $user['token'] = $token;
        event(new UserRegistredEvent($user));
        return $user;
    }

    public function logout()
    {
        auth()->logout('api');
        return "شما خارج شدید";
    }

    public function checkCode($root, array $args)
    {
        $code = $args['code'];
        $user = auth('api')->user();
        $codeForThisUserExists = Verification::
        where('user_id', $user->id)
            ->where('code', $code)->first();
        if ($codeForThisUserExists) {
            if ($codeForThisUserExists->used == true) {
                return [
                    'status' => 'error',
                    'message' => 'کد فعالسازی استفاده شده است',
                    'statusCode' => Response::HTTP_NOT_MODIFIED
                ];
            }
            if (strtotime($codeForThisUserExists->created_at) + strtotime('+5 minutes') >= Carbon::now()->timestamp) {
                $user->update([
                    'active' => true
                ]);
                $codeForThisUserExists->update([
                    'used' => true
                ]);
                return [
                    'status' => 'success',
                    'message' => 'حساب کاربری شما فعال شد',
                    'statusCode' => Response::HTTP_NO_CONTENT
                ];
            }
            return [
                'status' => 'error',
                'message' => 'کد فعالسازی منقضی شده است',
                'statusCode' => Response::HTTP_NOT_MODIFIED
            ];

        }
        return [
            'status' => 'error',
            'message' => 'کد فعالسازی نادرست است',
            'statusCode' => Response::HTTP_NOT_MODIFIED
        ];

    }

    public function sendCodeAgain()
    {
        $user = auth('api')->user();
        if ($user->active == false) {
            event(new UserRegistredEvent($user));
            return [
                'status' => 'success',
                'message' => 'کد فعالسازی برای شما ارسال شد',
                'statusCode' => Response::HTTP_CREATED
            ];
        }
        return [
            'status' => 'error',
            'message' => 'اکانت شما فعال است',
            'statusCode' => Response::HTTP_BAD_REQUEST
        ];
    }
}
