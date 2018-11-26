<?php
namespace Core\Middleware;

use Core\Dao\RegistroPeticionesDao;
use Slim\Http\Request;
use Slim\Http\Response;

class MWLog
{

    public static function guardarPeticion(Request $request, Response $response, $next)
    {
        $usuarioId = AutentificadorJWT::obtenerPayLoadDelRequest($request)->id;
        $metodo =  $request->getMethod();
        $ruta = $request->getUri()->__toString();
        $logId = RegistroPeticionesDao::crear($usuarioId,$metodo,$ruta);
        return $next($request, $response);
    }
}