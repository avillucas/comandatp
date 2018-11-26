<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 25/11/2018
 * Time: 5:50 PM
 */

namespace Core\Api;


use Core\Dao\UsuarioEntidadDao;
use Slim\Http\Request;
use Slim\Http\UploadedFile;

class SocioApi extends ApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $data = $this->getParams($request);
        $usuario = UsuarioEntidadDao::crearSocio($data['nombre'],$data['email'],$data['clave']);
        return $response->withJson(ApiUsable::RESPUESTA_CREADO,200);
    }

    public function TraerUno($request, $response, $args)
    {
        throw new SysNotImplementedException();// TraerUno() method.
    }

    public function TraerTodos($request, $response, $args)
    {
        throw new SysNotImplementedException();// TraerTodos() method.
    }

    public function BorrarUno($request, $response, $args)
    {
        throw new SysNotImplementedException();// BorrarUno() method.
    }

    public function ModificarUno($request, $response, $args)
    {
        throw new SysNotImplementedException();// ModificarUno() method.
    }


}