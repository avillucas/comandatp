<?php
namespace Core\Api;


use Core\Dao\AlimentoEntidadDao;
use Core\Dao\ComandaEntidadDao;
use Core\Dao\EstadoPedidoEntidadDao;
use Core\Dao\MozoEntidadDao;
use Core\Dao\PedidoEntidadDao;
use Core\Dao\PreparadorEntidadDao;
use Core\Exceptions\SysNotImplementedException;
use Core\Exceptions\SysValidationException;
use Core\Mozo;
use Core\Pedido;
use Core\Preparador;
use Slim\Http\Request;
use Slim\Http\UploadedFile;

class PedidoApi extends ApiUsable
{

    public function alaorden($request, $response, $args)
    {
        $data = $this->getParams($request);
        $payload = $this->getPayloadActual($request);
        $preparador = PreparadorEntidadDao::traerUnoPorEmpleadoId($payload->empledo_id);
        //
        /** @var Pedido $pedido */
        $pedido = PedidoEntidadDao::traerUno($data['pedido_id']);
        //
        if(!$pedido->isEnPreparacion())
        {
            throw new SysValidationException("El pedido no se encuentra en preparacion , por lo tanto no puede ser preparado");
        }
        if(!$pedido->getEncargado()->getId())
        {
            throw new SysValidationException("El pedido no esta siendo procesaro por este usuario");
        }
        $pedido->setMomentoDeEntrega(new \DateTime());
        $pedido->setEstado(EstadoPedidoEntidadDao::traerParaServir());
        PedidoEntidadDao::save($pedido);
        //
        return $response->withJson([
            'response' => 'El pedido ya esta listo para servir pertenece a la comanda '.$pedido->getComanda()->getCodigo()
        ],200);
    }

    public function preparar($request, $response, $args)
    {
        $data = $this->getParams($request);
        $payload = $this->getPayloadActual($request);
        $preparador = PreparadorEntidadDao::traerUnoPorEmpleadoId($payload->empledo_id);
        //
        /** @var Pedido $pedido */
        $pedido = PedidoEntidadDao::traerUno($data['pedido_id']);
        //
        if(!$pedido->isPendiente())
        {
            throw new SysValidationException("El pedido no se encuentra pendiente , por lo tanto no puede ser preparado");
        }

        $pedido->setEncargado($preparador);
        $pedido->setTiempoEstimado($data['tiempo_estimado']);
        $pedido->setMomentoPreparacionInicio(new \DateTime());
        $pedido->setEstado(EstadoPedidoEntidadDao::traerEnPreparacion());

        PedidoEntidadDao::save($pedido);
        //
        return $response->withJson([
            'response' => 'El pedido esta siendo preparado , pertenece a la comanda '.$pedido->getComanda()->getCodigo(),
            'data' => ['tiempoEstimado'=>  $pedido->getTiempoEstimado()],
        ],200);
    }

    public function CargarUno($request, $response, $args)
    {
        $data = $this->getParams($request);
        $comanda = ComandaEntidadDao::traerUno($data['comanda_id']);
        $alimento = AlimentoEntidadDao::traerUno($data['alimento_id']);
        $pedido = new Pedido(null,$comanda,$alimento,null,intval($data['cantidad']));
        PedidoEntidadDao::save($pedido);
        return $response->withJson([
            'response' => 'Pedido cargado en la comnada , codigo : '.$comanda->getCodigo(),
            'data' => ['comandaCodigo'=>  $comanda->getCodigo()],
        ],200);
    }

    public function TraerUno($request, $response, $args)
    {
        $pedido = PedidoEntidadDao::traerUno($args['id']);
        return $response->withJson($pedido->__toArray(), 200);;
    }

    public function TraerTodos($request, $response, $args)
    {
        $todos = PedidoEntidadDao::traerTodosConRelaciones();
        return $response->withJson($todos, 200);
    }

    public function TraerPendientes($request, $response, $args)
    {
        $payload = $this->getPayloadActual($request);
        if($payload->isPreparador)
        {
            // si es un preparador ve solo las de su sector
            /** @var Preparador $preparador */
            $preparador = PreparadorEntidadDao::traerUnoPorEmpleadoId($payload->empledo_id);
            $todos = PedidoEntidadDao::traerTodasLasPendientePorSector($preparador->getSector()->getId());
        }
        elseif($payload->isMozo)
        {
            // si es un mozo ve las que tiene asociadas
            /** @var Mozo $mozo */
            $mozo = MozoEntidadDao::traerUnoPorEmpleadoId($payload->empledo_id);
            $todos = PedidoEntidadDao::traerTodasLasPendienteDelMozo($mozo->getId());
        }
        else
        {
            // si es un admin ve todas las pendientes
            $todos = PedidoEntidadDao::traerTodosConRelaciones();
        }
        return $response->withJson($todos, 200);
    }

    public function TraerParaServir($request, $response, $args)
    {
        $payload = $this->getPayloadActual($request);
        // si es un mozo ve las que tiene asociadas
        /** @var Mozo $mozo */
        $mozo = MozoEntidadDao::traerUnoPorEmpleadoId($payload->empledo_id);
        $todos = PedidoEntidadDao::traerParaServirDelMozo($mozo->getId());
        return $response->withJson($todos, 200);
    }

    public function BorrarUno($request, $response, $args)
    {
        throw  new SysNotImplementedException();
    }

    public function ModificarUno($request, $response, $args)
    {
        // TODO: Implement ModificarUno() method.
    }

}