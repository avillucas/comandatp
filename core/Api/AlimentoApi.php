<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 25/11/2018
 * Time: 6:53 PM
 */

namespace Core\Api;


use Core\Alimento;
use Core\Dao\AlimentoEntidadDao;
use Core\Dao\SectorEntidadDao;
use Slim\Http\Request;
use Slim\Http\UploadedFile;

class AlimentoApi extends ApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $data = $this->getParams($request);
        $sector = SectorEntidadDao::traerOFallar($data['sector_id']);
        $alimento = new Alimento(null,$data['nombre'],$data['precio'],$sector);
        AlimentoEntidadDao::save($alimento);
        return $response->withJson(ApiUsable::RESPUESTA_CREADO,200);
    }

    public function TraerUno($request, $response, $args)
    {
        $alimento = AlimentoEntidadDao::traerUno($args['id']);
        return $response->withJson($alimento->__toArray(), 200);
    }

    public function TraerTodos($request, $response, $args)
    {
       $todos = AlimentoEntidadDao::traerTodosConRelaciones();
       return $response->withJson($todos, 200);
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