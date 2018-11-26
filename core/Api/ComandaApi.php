<?php
namespace Core\Api;

use Core\Comanda;
use Core\Dao\AlimentoEntidadDao;
use Core\Dao\ComandaEntidadDao;
use Core\Dao\EstadoMesaEntidadDao;
use Core\Dao\MesaEntidadDao;
use Core\Dao\MozoEntidadDao;
use Core\Dao\PedidoEntidadDao;
use Core\Exceptions\SysNotImplementedException;
use Core\Exceptions\SysValidationException;
use Core\Mesa;
use Core\Mozo;
use Core\Pedido;
use Slim\Http\Request;
use Slim\Http\UploadedFile;

class ComandaApi extends  ApiUsable
{
    public function tomar($request, $response, $args)
    {
        $data = $this->getParams($request);
        $payload = $this->getPayloadActual($request);
        $mozo = MozoEntidadDao::traerUnoPorEmpleadoId($payload->empledo_id);
        $comanda =  $this->crearComanda($data,$mozo);
        return $response->withJson([
            'response' => 'Comanda creada , codigo : '.$comanda->getCodigo(),
            'data' => ['comandaCodigo'=>  $comanda->getCodigo()],
        ],200);
    }

    public function CargarUno($request, $response, $args)
    {
        $data = $this->getParams($request);
        $mozo = MozoEntidadDao::traerOFallar($data['mozo_id']);
        $comanda =  $this->crearComanda($data,$mozo);
        return $response->withJson([
            'response' => 'Comanda creada , codigo : '.$comanda->getCodigo(),
            'data' => ['comandaCodigo'=>  $comanda->getCodigo()],
        ],200);
    }


    private function crearComanda($data,Mozo $mozo)
    {
        /** @var Mesa $mesa */
        $mesa = MesaEntidadDao::traerUnoPorCodigo($data['codigo_mesa']);
        if(!$mesa->isCerrada())
        {
            throw  new SysValidationException("La mesa para la que esta tomando el pedido esta ocupada");
        }
        //
        $comanda = new Comanda(null,$mozo,$mesa,$data['nombre_cliente']);
        ComandaEntidadDao::save($comanda);
        //
        $mesa->setEstado(EstadoMesaEntidadDao::traerEstadoEsperando());
        MesaEntidadDao::save($mesa);
        if(isset($data['pedidos'])){
            foreach($data['pedidos'] as $pedidoRequest)
            {
                $alimento = AlimentoEntidadDao::traerUno($pedidoRequest['alimento_id']);
                $pedido = new Pedido(null,$comanda,$alimento,null,intval($pedidoRequest['cantidad']));
                PedidoEntidadDao::save($pedido);
            }
        }
        return $comanda;
    }

    public function TraerUno($request, $response, $args)
    {
        $mesa = ComandaEntidadDao::traerUno($args['id']);
        return $response->withJson($mesa->__toArray(), 200);
    }

    public function TraerTodos($request, $response, $args)
    {
        $todos = ComandaEntidadDao::traerTodosConRelaciones();
        return $response->withJson($todos, 200);
    }

    public function BorrarUno($request, $response, $args)
    {
        $comanda = ComandaEntidadDao::traerOFallar($args['id']);
        PedidoEntidadDao::eliminar($comanda);
        return $response->withJson(ApiUsable::RESPUESTA_ELIMINADO,200);
    }

    public function ModificarUno($request, $response, $args)
    {
        /** @var Comanda $comanda */
        $comanda = ComandaEntidadDao::traerOFallar($args['id']);
        $data = $this->getParams($request);
        if(isset($data['mozo_id']))
        {
            $mozo = MozoEntidadDao::traerOFallar($data['mozo_id']);
            $comanda->setMozo($mozo);
        }
        if(isset($data['codigo_mesa']))
        {
            $mesa = MesaEntidadDao::traerUnoPorCodigo($data['codigo_mesa']);
            $comanda->setMesa($mesa);
        }
        if(isset($data['nombre_cliente']))
        {
            $comanda->setNombreCliente($data['nombre_cliente']);
        }
        //
        ComandaEntidadDao::save($comanda);
        return $response->withJson(ApiUsable::RESPUESTA_MODIFICADO,200);
    }


}