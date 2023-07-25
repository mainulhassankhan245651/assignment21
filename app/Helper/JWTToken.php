<?php
namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PHPUnit\Metadata\Exception;


class JWTToken{

    public static function CreateToken($userEmail,$userID):string{
        $key=env('JWT_KEY');
        $payload = [
            'iss' => "laravel-jwt",
            'iat' => time(),
            'exp' => time() + 60*60,
            'userEmail' => $userEmail,
            'userID' => $userID
        ];
        return JWT::encode($payload, $key,'HS256');
    }

    public static function DecodeToken($token):string{
        try {
            $key=env('JWT_KEY');
            $decoded=JWT::decode($token, new Key($key,'HS256'));
            return $decoded->userEmail;
        }
        catch(Exception $e){
            return "unauthorized";
        }
    }
    public static function CreateTokenForSetPassword($userEmail):string{
        $key =env('JWT_KEY');
        $payload=[
            'iss'=>'laravel-token',
            'iat'=>time(),
            'exp'=>time()+60*20,
            'userEmail'=>$userEmail,
            'userID'=>'0'
        ];
        return JWT::encode($payload,$key,'HS256');
    }
    public static function VerifyToken($token):object|string
    {
        try {
            if($token==null){
                return 'unauthorized';
            }
            else{
                $key =env('JWT_KEY');
                $decode=JWT::decode($token,new Key($key,'HS256'));
                return $decode;
            }
        }
        catch (Exception $e){
            return 'unauthorized';
        }
    }

}