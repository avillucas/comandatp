<?php
namespace Core\Api;

use Core\Dao\UsuarioEntidadDao;
use Core\Exceptions\SysNotImplementedException;
use Core\Middleware\AutentificadorJWT;
use Core\Usuario;

class UsuarioApi extends ApiUsable
{
    public function cargarUno($request, $response, $args)
    {
        $data = $this->getParams($request);
        Usuario::crear($data);
        return $response->withJson(ApiUsable::RESPUESTA_CREADO,200);
    }

    public function login($request, $response, $args)
    {
        $email = $this->getParam($request,'email');
        $clave = $this->getParam($request,'clave');
        $usuario = Usuario::login($email, $clave);
        //TOKEN
        $data = $usuario->traerTokenPayload();
        $token = AutentificadorJWT::crearToken($data);
        return $response->withJson(['token'=>$token],200);
    }

    public function TraerUno($request, $response, $args)
    {
        throw new SysNotImplementedException();
    }

    public function TraerTodos($request, $response, $args)
    {
        $usuarios= UsuarioEntidadDao::traerTodos();
        return $response->withJson($usuarios, 200);
    }

    public function BorrarUno($request, $response, $args)
    {
        throw new SysNotImplementedException();
    }

    public function ModificarUno($request, $response, $args)
    {
        throw new SysNotImplementedException();
    }


}