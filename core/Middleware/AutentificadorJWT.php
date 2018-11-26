<?php

namespace Core\Middleware;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Slim\Http\Request;

class AutentificadorJWT
{
    const TOKEN_WORD = 'Bearer';

    private static $claveSecreta = JWT_SECRET;
    private static $tipoEncriptacion = ['HS256'];
    private static $aud = null;

    public static function crearToken($datos)
    {
        $ahora = time();
        /*
         parametros del payload
         https://tools.ietf.org/html/rfc7519#section-4.1
         + los que quieras ej="'app'=> "API REST CD 2017" 
        */
        $payload = array(
            'iat'=>$ahora,
            'exp' => $ahora + (60*60),
            'aud' => self::aud(),
            'data' => $datos,
            'app'=> API_NAME
        );

        return JWT::encode($payload, self::$claveSecreta);
    }

    public static function verificarBarearToken(Request $request)
    {

        //Autorization O HTTP_AUTHORIZATION header
        $tokenStr = $request->getHeader('HTTP_AUTHORIZATION');
        if(empty($tokenStr))
        {
            throw new \Exception("Cabecera de autenticacion mal formada");
        }
        $tokenParts = explode(' ',$tokenStr[0]);
        if($tokenParts[0] != AutentificadorJWT::TOKEN_WORD)
        {
            throw new \Exception("Cabecera de autenticacion mal formada");
        }
        $token= $tokenParts[1];
        try
        {
            self::verificarToken($token);
        }
        catch (ExpiredException $e)
        {

            throw $e;
        }
        return $token;
    }

    public static function verificarToken($token)
    {

        if(empty($token)|| $token=="")
        {
            throw new \Exception("El token esta vacio.");
        }
        // las siguientes lineas lanzan una excepcion, de no ser correcto o de haberse terminado el tiempo
        try {
            $decodificado = JWT::decode(
                $token,
                self::$claveSecreta,
                self::$tipoEncriptacion
            );
        }
        catch (ExpiredException $e)
        {
            throw new \Exception("Clave fuera de tiempo");
        }catch (\Exception $e )
        {
            throw $e;
        }

        // si no da error,  verifico los datos de AUD que uso para saber de que lugar viene  
        if($decodificado->aud !== self::aud())
        {
            throw new \Exception("No es el usuario valido");
        }
        return $decodificado;
    }

    public static function obtenerPayLoadDelRequest($request)
    {
        $token = self::verificarBarearToken($request);
        return self::obtenerData($token);
    }

    public static function obtenerPayLoad($token)
    {
        return JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        );
    }

    public static function obtenerData($token)
    {
        return JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        )->data;
    }

    private static function aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}