<?php
namespace Core\Middleware;

use Core\Dao\RegistroAccesoDao;
use Slim\Http\Request;
use Slim\Http\Response;

class MWLog
{

    public static function guardarLogin(Request $request, Response $response, $next)
    {
        $usuarioId = AutentificadorJWT::obtenerPayLoadDelRequest($request)->id;
        $logId = RegistroAccesoDao::registrar($usuarioId);
        return $next($request, $response);
    }
}