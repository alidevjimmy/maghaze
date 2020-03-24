<?php

namespace App\GraphQL\Mutations;

use App\User;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthMutator
{
    public function login($root, array $args)
    {
        $credentials = Arr::only($args, ['phone', 'password']);
        try {
            if ($token =  JWTAuth::attempt($credentials)) {
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
        return $user;
    }

    public function logout()
    {
        auth()->logout('api');
        return "شما خارج شدید";
    }
}
