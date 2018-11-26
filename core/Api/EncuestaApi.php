<?php
namespace Core\Api;


use Core\Comanda;
use Core\Dao\ComandaEntidadDao;
use Core\Dao\EncuestaDao;
use Core\Encuesta;
use Core\Exceptions\SysNotImplementedException;
use Slim\Http\Request;
use Slim\Http\UploadedFile;

class EncuestaApi extends ApiUsable
{

    public function CargarUno($request, $response, $args)
    {
        $data = $this->getParams($request);
        //
        $comanda = ComandaEntidadDao::traerUnoPorCodigo($data['comanda_codigo']);
        $comentario = (isset($data['comentario'])) ? $data['comentario']:null;
        $encuesta = new Encuesta(null,$comanda ,$data['puntuacion_restaurante'] ,$data['puntuacion_mozo'] ,$data['puntuacion_preparador'],$data['puntuacion_mesa']  ,$comentario);
        //
        EncuestaDao::save($encuesta);
        return $response->withJson(ApiUsable::RESPUESTA_CREADO,200);
    }

    public function TraerUno($request, $response, $args)
    {
        $mesa = EncuestaDao::traerUno($args['id']);
        return $response->withJson($mesa->__toArray(), 200);
    }

    public function TraerTodos($request, $response, $args)
    {
        $todos = EncuestaDao::traerTodosConRelaciones();
        return $response->withJson($todos, 200);
    }

    public function BorrarUno($request, $response, $args)
    {
        $encuesta = EncuestaDao::traerOFallar($args['id']);
        EncuestaDao::eliminar($encuesta);
        return $response->withJson(ApiUsable::RESPUESTA_ELIMINADO,200);
    }

    public function ModificarUno($request, $response, $args)
    {
        /** @var Encuesta $encuesta */
        $encuesta = EncuestaDao::traerOFallar($args['id']);
        $data = $this->getParams($request);
        if(isset($data['comanda_codigo']))
        {
            $comanda = ComandaEntidadDao::traerOFallar($data['comanda_codigo']);
            $encuesta->setC($comanda);
        }
        if(isset($data['puntuacion_restaurante']))
        {
            $encuesta->setPuntuacionRestaurante($data['puntuacion_restaurante']);
        }
        if(isset($data['puntuacion_mozo']))
        {
            $encuesta->setPuntuacionMozo($data['puntuacion_mozo']);
        }
        if(isset($data['puntuacion_preparador']))
        {
            $encuesta->setPuntuacionPreparador($data['puntuacion_preparador']);
        }
        if(isset($data['puntuacion_mesa']))
        {
            $encuesta->setPuntuacionMesa($data['puntuacion_mesa']);
        }
        if(isset($data['comentario']))
        {
            $encuesta->setComentario($data['comentario']);
        }
        //
        EncuestaDao::save($encuesta);
        return $response->withJson(ApiUsable::RESPUESTA_MODIFICADO,200);
    }

}