<?php

namespace Core\Api;


use Core\Dao\EstadoMesaEntidadDao;
use Core\Dao\MesaEntidadDao;
use Core\Exceptions\SysValidationException;
use Core\Mesa;
use Slim\Http\Request;
use Slim\Http\UploadedFile;

class MesaApi extends ApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $data = $this->getParams($request);
        $mesa = new Mesa($data['codigo'],null);
        MesaEntidadDao::save($mesa);
        return $response->withJson(ApiUsable::RESPUESTA_CREADO,200);
    }

    public function TraerUno($request, $response, $args)
    {
        $mesa = MesaEntidadDao::traerUno($args['id']);
        return $response->withJson($mesa->__toArray(), 200);
    }

    public function TraerTodos($request, $response, $args)
    {
        $todos = MesaEntidadDao::traerTodosConRelaciones();
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

    public function MarcarClienteComiendo($request, $response, $args)
    {
        $data = $this->getParams($request);
        /** @var Mesa $mesa */
        $mesa = MesaEntidadDao::traerUnoPorCodigo($data['mesa_codigo']);
        if(!$mesa->isEsperando())
        {
            throw new SysValidationException("La mesa debe tener clientes esperando para poder cambiar su estado a comiendo");
        }
        $mesa->setEstado(EstadoMesaEntidadDao::traerEstadoComiendo());
        MesaEntidadDao::save($mesa);
        //
        return $response->withJson([
            'response' => 'La mesa '.$mesa->getCodigo().' tiene clientes comiendo'
        ],200);
    }

    public function MarcarPagando($request, $response, $args)
    {
        $data = $this->getParams($request);
        /** @var Mesa $mesa */
        $mesa = MesaEntidadDao::traerUnoPorCodigo($data['mesa_codigo']);
        if(!$mesa->isComiendo())
        {
            throw new SysValidationException("La mesa debe tener clientes comiendo para poder pagar");
        }
        $mesa->setEstado(EstadoMesaEntidadDao::traerEstadoPagando());
        MesaEntidadDao::save($mesa);
        //
        return $response->withJson([
            'response' => 'La mesa '.$mesa->getCodigo().' tiene cliente pagando'
        ],200);
    }

    public function cerrar($request, $response, $args)
    {
        $data = $this->getParams($request);
        /** @var Mesa $mesa */
        $mesa = MesaEntidadDao::traerUnoPorCodigo($data['mesa_codigo']);
        $mesa->setEstado(EstadoMesaEntidadDao::traerEstadoCerrado());
        MesaEntidadDao::save($mesa);
        //
        return $response->withJson([
            'response' => 'La mesa '.$mesa->getCodigo().' esta Cerrada'
        ],200);
    }

}