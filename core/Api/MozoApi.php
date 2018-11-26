<?php
namespace Core\Api;


use Core\Dao\MozoEntidadDao;
use Core\Dao\UsuarioEntidadDao;
use Core\Mozo;

class MozoApi extends ApiUsable
{


    public function CargarUno($request, $response, $args)
    {
        $data = $this->getParams($request);
        $usuario = UsuarioEntidadDao::crearMozo($data['nombre'],$data['email'],$data['clave']);
        return $response->withJson(ApiUsable::RESPUESTA_CREADO,200);
    }

    public function TraerUno($request, $response, $args)
    {
        $mesa = MozoEntidadDao::traerUno($args['id']);
        return $response->withJson($mesa->__toArray(), 200);
    }

    public function TraerTodos($request, $response, $args)
    {
        $todos = MozoEntidadDao::traerTodosConRelaciones();
        return $response->withJson($todos, 200);
    }

    public function BorrarUno($request, $response, $args)
    {
       $mozo = MozoEntidadDao::traerOFallar($args['id']);
       MozoEntidadDao::eliminar($mozo);
        return $response->withJson(ApiUsable::RESPUESTA_ELIMINADO,200);
    }

    public function ModificarUno($request, $response, $args)
    {
        /** @var Mozo $mozo */
        $mozo = MozoEntidadDao::traerOFallar($args['id']);
        $data = $this->getParams($request);
        if(isset($data['empledo_id']))
        {
            $mozo->setEmpleado($data['empledo_id']);
        }
        MozoEntidadDao::save($mozo);
        return $response->withJson(ApiUsable::RESPUESTA_MODIFICADO,200);
    }


}