<?php
namespace Core\Api;

use Core\Dao\ResultadoEntidadDao;
use Core\Dao\UsuarioEntidadDao;
use Core\Middleware\AutentificadorJWT;
use Core\Usuario;

class ResultadosApi extends ApiUsable
{
    //cargar un socio
    public function cargarUno($request, $response, $args)
    {
        $data = $this->getParams($request);
        // TODO tomar despues los datos
        // $usuarioId = AutentificadorJWT::obtenerPayLoadDelRequest($request)->id;
        $usuarioId = 1;
        $usuario = UsuarioEntidadDao::traerOFallar($usuarioId);
        $resultado = ResultadoEntidadDao::crear($data['gano'],$data['juego'],$usuario);
        return $response->withJson(ApiUsable::RESPUESTA_CREADO,200);
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
        $data = $this->getParams($request);
        /** @var Usuario $usuario */
        $usuario = UsuarioEntidadDao::traerOFallar($args['id']);

        if(isset($data['nombre']))
        {
            $usuario->setNombre($data['nombre']);
        }
        if(isset($data['email']))
        {
            $usuario->setEmail($data['email']);
        }
        if(isset($data['clave']))
        {
            $usuario->setClave($data['clave']);
        }
        UsuarioEntidadDao::save($usuario);
        return $response->withJson(ApiUsable::RESPUESTA_CREADO,200);
    }

}
