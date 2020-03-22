<?php

namespace App\GraphQL\Mutations;

use App\User;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthMutator
{
    public function login($root , array $args)
    {
        $credentials = Arr::only($args , ['phone' , 'password']);
        $credentials = ['phone' => $credentials['phone'] , 'password' => $credentials['password']];
        try {
            if (!$token = auth()->attempt($credentials)) {
                return ['token' => null];
            }
        } catch (JWTException $e) {
            return ['token' => null];
        }
        return [
            'token' => compact('token')
        ];
    }

    public function register($root , array $args)
    {
        $user = User::create([
            'phone'    => $args['phone'],
            'name'    => $args['name'],
            'family'    => $args['family'],
            'password'    => $args['password'],
        ]);
        $token = auth()->login($user);
        return $user;

    }
}
