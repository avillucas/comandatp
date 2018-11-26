<?php
namespace Core\Api;

use Core\Dao\EmpleadoEntidadDao;
use Core\Dao\UsuarioEntidadDao;
use Core\Exceptions\SysNotImplementedException;
use Core\Middleware\AutentificadorJWT;
use Core\Usuario;

class UsuarioApi extends ApiUsable
{
    //cargar un socio
    public function cargarUno($request, $response, $args)
    {
        $data = $this->getParams($request);
        $empleado = null;
        if(isset($data['empleado_id']))
        {
            $empleado = EmpleadoEntidadDao::traerOFallar($data['empleado_id']);
        }
        $usuario = UsuarioEntidadDao::crear($data['nombre'],$data['email'],$data['clave'],$empleado);
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
        $mesa = UsuarioEntidadDao::traerUno($args['id']);
        return $response->withJson($mesa->__toArray(), 200);
    }

    public function TraerTodos($request, $response, $args)
    {
        $todos = UsuarioEntidadDao::traerTodosConRelaciones();
        return $response->withJson($todos, 200);
    }

    public function BorrarUno($request, $response, $args)
    {
        $usuario = UsuarioEntidadDao::traerOFallar($args['id']);
        UsuarioEntidadDao::eliminar($usuario);
        return $response->withJson(ApiUsable::RESPUESTA_ELIMINADO,200);
    }

    public function ModificarUno($request, $response, $args)
    {
        throw new SysNotImplementedException();
    }


}