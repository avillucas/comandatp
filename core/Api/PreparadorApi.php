<?php
namespace Core\Api;


use Core\Dao\PreparadorEntidadDao;
use Core\Dao\UsuarioEntidadDao;
use Core\Preparador;
use Slim\Http\Request;
use Slim\Http\UploadedFile;

class PreparadorApi extends ApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $data = $this->getParams($request);
        $usuario = UsuarioEntidadDao::crearPreparador($data['nombre'],$data['email'],$data['clave'],$data['sector_id']);
        return $response->withJson(ApiUsable::RESPUESTA_CREADO,200);
    }

    public function TraerUno($request, $response, $args)
    {
        $mesa = PreparadorEntidadDao::traerUno($args['id']);
        return $response->withJson($mesa->__toArray(), 200);
    }

    public function TraerTodos($request, $response, $args)
    {
        $todos = PreparadorEntidadDao::traerTodosConRelaciones();
        return $response->withJson($todos, 200);
    }

    public function BorrarUno($request, $response, $args)
    {
        $preparador = PreparadorEntidadDao::traerOFallar($args['id']);
        PreparadorEntidadDao::eliminar($preparador);
        return $response->withJson(ApiUsable::RESPUESTA_ELIMINADO,200);
    }

    public function ModificarUno($request, $response, $args)
    {
        /** @var Preparador $preparador */
        $preparador = PreparadorEntidadDao::traerOFallar($args['id']);
        $data = $this->getParams($request);
        $preparador->setEmpleado($data['empledo_id']);
        PreparadorEntidadDao::save($preparador);
        return $response->withJson(ApiUsable::RESPUESTA_MODIFICADO,200);
    }


}