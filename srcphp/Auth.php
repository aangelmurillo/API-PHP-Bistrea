<?php

namespace proyecto;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use proyecto\Models\usuario;

class Auth
{
    private $usuario;

    public static function generateToken($data, $time = 3600): string
    {
        $t = Carbon::now()->timestamp + $time;
        $key = 'bistrea1234';
        $payload = ['exp' => $t, 'data' => $data];
        return JWT::encode($payload, $key, 'HS256');
    }

    /**
     * @return mixed
     */
    public static function getUser()
    {
        $secretKey = 'bistrea1234';
        $jwt = Router::getBearerToken();
        $token = JWT::decode($jwt, new key($secretKey, 'HS256'));
        return usuario::find($token->data[0]);
    }

    /**
     * @param mixed $user
     */
    public static function setUser($email_usuario): void
    {
        $session = new Session();
        $session->set('email_usuario', $email_usuario);

    }

    public function clearUser($email_usuario): void
    {
        $se = new Session();
        $se->remove("email_usuario");
    }


}
