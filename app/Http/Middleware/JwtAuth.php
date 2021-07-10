<?php

namespace App\Http\Middleware;

use \App\Model\Entity\User;
use \Firebase\JWT\JWT;

class JwtAuth
{
    private function getJwtAuthUser($request) {
        $headers = $request->getHeaders();

        $jwt = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : '';

        try {
            $decoded = (array) JWT::decode($jwt, JWT_KEY, array('HS256'));
        } catch (\Exception $e) {
            throw new \Exception("Token inválido.", 403);            
        }

        $email = $decoded['email'] ?? '';
        $obUser = User::getUserByEmail($email);

        return $obUser instanceof User ? $obUser : false;
    }

    private function auth($request) {
        if ($obUser = $this->getJwtAuthUser($request)) {
            $request->user = $obUser;
            return true;
        }

        throw new \Exception("Usuário ou senha inválidos.", 403);        
    }

    public function handle($request, $next) {
        $this->auth($request);

        return $next($request);
    }
}