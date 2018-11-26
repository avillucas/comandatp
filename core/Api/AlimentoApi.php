<?php
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
        $alimento = AlimentoEntidadDao::traerOFallar($args['id']);
        AlimentoEntidadDao::eliminar($alimento);
        return $response->withJson(ApiUsable::RESPUESTA_ELIMINADO,200);
    }

    public function ModificarUno($request, $response, $args)
    {
        /** @var Alimento $alimento */
        $alimento = AlimentoEntidadDao::traerOFallar($args['id']);
        $data = $this->getParams($request);
        if(isset($data['sector_id']))
        {
            $sector = SectorEntidadDao::traerOFallar($data['sector_id']);
            $alimento->setSector($sector);
        }
        if(isset($data['precio']))
        {
            $alimento->setPrecio($data['precio']);
        }
        if(isset($data['nombre']))
        {
            $alimento->setNombre($data['nombre']);
        }
        AlimentoEntidadDao::save($alimento);
        return $response->withJson(ApiUsable::RESPUESTA_MODIFICADO,200);
    }


}