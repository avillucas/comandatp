<?php
namespace Core\Middleware;

use Core\Alimento;
use Core\Dao\AlimentoEntidadDao;
use Core\Dao\PedidoEntidadDao;
use Core\Dao\PreparadorEntidadDao;
use Core\Dao\UsuarioEntidadDao;
use Core\Exceptions\SysValidationException;
use Core\Pedido;
use Core\Preparador;
use Core\Usuario;
use Slim\Http\Request;

class MWparaAutentificar
{
 /**
   * @api {any} /MWparaAutenticar/  Verificar Usuario
   * @apiVersion 0.1.0
   * @apiName VerificarUsuario
   * @apiGroup MIDDLEWARE
   * @apiDescription  Por medio de este MiddleWare verifico las credeciales antes de ingresar al correspondiente metodo 
   *
   * @apiParam {ServerRequestInterface} request  El objeto REQUEST.
   * @apiParam {ResponseInterface} response El objeto RESPONSE.
   * @apiParam {Callable} next  The next middleware callable.
   *
   * @apiExample Como usarlo:
   *    ->add(\MWparaAutenticar::class . ':VerificarUsuario')
   */
    private function verificarBarearTokenOrFail($request)
    {
        try
        {
            $token =  AutentificadorJWT::verificarBarearToken($request);
        }
        catch (\Exception $e)
        {
            throw new SysValidationException("El token es invalido",null,$e);
        }
        return $token;
    }

	public function verificarUsuario($request, $response, $next)
    {
       $token= $this->verificarBarearTokenOrFail($request);
        return $next($request, $response);
	}

}