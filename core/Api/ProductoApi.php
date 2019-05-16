<?php
namespace Core\Api;

use Core\Dao\EmpleadoEntidadDao;
use Core\Dao\RegistroAccesoDao;
use Core\Dao\UsuarioEntidadDao;
use Core\Dao\HeladoEntidadDao;
use Core\Exceptions\SysNotImplementedException;
use Core\Middleware\AutentificadorJWT;
use Core\Middleware\MWLog;
use Core\Usuario;
use Core\Dao\ProductoEntidadDao;

class ProductoApi extends ApiUsable
{
    
    public function Buscar($request, $response, $args)
    {        
        $todos = ProductoEntidadDao::traerTodosConRelaciones();
        return $response->withJson($todos, 200);
    }

    public function TraerTodos($request, $response, $args)
    {        
        $todos = ProductoEntidadDao::traerTodosConRelaciones();
        return $response->withJson($todos, 200);
    }

    public function BorrarUno($request, $response, $args)
    {        
        $producto = ProductoEntidadDao::traerUno($args['id']);
        ProductoEntidadDao::eliminar($producto);
        return $response->withJson(ApiUsable::RESPUESTA_ELIMINADO,200);
    }

    public function cargarUno($request, $response, $args)
    {
        $data = $this->getParams($request);
        $producto = ProductoEntidadDao::crear($data['tipo'],$data['descripcion'],$data['fechaVencimiento'],floatval($data['precio']),null);
        return $response->withJson(ApiUsable::RESPUESTA_CREADO,200);
    }

    

/***  */    
    public function TraerUno($request, $response, $args)
    {
        $mesa = HeladoEntidadDao::traerUno($args['id']);
        return $response->withJson($mesa->__toArray(), 200);
    }

    
   

    public function ModificarUno($request, $response, $args)
    {
        $data = $this->getParams($request);        
        $usuario = HeladoEntidadDao::traerOFallar($args['id']);

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
        if(isset($data['empleado_id']))
        {
            $empleado = EmpleadoEntidadDao::traerOFallar($data['empleado_id']);
            $usuario->setEmpleado($empleado);
        }
        UsuarioEntidadDao::save($usuario);
        return $response->withJson(ApiUsable::RESPUESTA_CREADO,200);
    }



}