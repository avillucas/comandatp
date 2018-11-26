<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 25/11/2018
 * Time: 7:27 PM
 */

namespace Core;


use Core\Dao\EstadoPedidoEntidadDao;
use Core\Dao\PreparadorEntidadDao;

class Pedido extends Entidad
{
    /** @var Alimento $alimento */
    private $alimento;

    /** @var Preparador $encargado */
    private $encargado = null;

    /** @var int $cantidad */
    private $cantidad;

    /** @var int $tiempoEstimado */
    private $tiempoEstimado = null;

    /** @var \DateTime $momentoCreacion */
    private $momentoCreacion = null;

    /** @var \DateTime $momentoPreparacionInicio */
    private $momentoPreparacionInicio = null;

    /** @var \DateTime $momentoDeEntrega */
    private $momentoDeEntrega = null;

    /** @var EstadoPedido $estado */
    private $estado;

    /** @var Comanda $comanda */
    private $comanda;

    /**
     * Pedido constructor.
     * @param Alimento $alimento
     * @param Preparador $encargado
     * @param int $cantidad
     * @param int $tiempoEstimado
     * @param \DateTime $momentoCreacion
     * @param \DateTime $momentoPreparacionInicio
     * @param \DateTime $momentoDeEntrega
     * @param EstadoPedido $estado
     */
    public function __construct($id = null, Comanda $comanda, Alimento $alimento, Preparador $encargado=null, $cantidad,  $tiempoEstimado=null, \DateTime $momentoCreacion=null, \DateTime $momentoPreparacionInicio=null, \DateTime $momentoDeEntrega=null, EstadoPedido $estado=null)
    {
        $this->setId($id);
        $this->setComanda($comanda);
        $this->setAlimento($alimento);
        $this->setEncargado($encargado);
        $this->setCantidad($cantidad);
        $this->setTiempoEstimado($tiempoEstimado);
        $this->setMomentoCreacion($momentoCreacion);
        $this->setMomentoPreparacionInicio($momentoPreparacionInicio);
        $this->setMomentoDeEntrega($momentoDeEntrega);
        if(!isset($estado))
        {
            $estado = EstadoPedidoEntidadDao::getDefault();
        }
        $this->setEstado($estado);
    }

    function __toArray()
    {
        $array = [
            'id' => $this->getId(),
            'estado'=> $this->getEstado()->getNombre(),
            'alimento' => $this->getAlimento()->getNombre(),
            'cantidad' => $this->getCantidad(),
        ];
        return $array;
    }

    /**
     * @return Comanda
     */
    public function getComanda()
    {
        return $this->comanda;
    }

    /**
     * @param Comanda $comanda
     */
    public function setComanda($comanda)
    {
        $this->comanda = $comanda;
    }

    /**
     * @return Alimento
     */
    public function getAlimento()
    {
        return $this->alimento;
    }

    /**
     * @param Alimento $alimento
     */
    public function setAlimento($alimento)
    {
        $this->alimento = $alimento;
    }

    /**
     * @return Preparador
     */
    public function getEncargado()
    {
        return $this->encargado;
    }

    /**
     * @param Preparador $encargado
     */
    public function setEncargado($encargado)
    {
        $this->encargado = $encargado;
    }

    /**
     * @return int
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param int $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = intval($cantidad);
    }

    /**
     * @return \DateTime
     */
    public function getTiempoEstimado()
    {
        return $this->tiempoEstimado;
    }

    /**
     * @param int $tiempoEstimado
     */
    public function setTiempoEstimado($tiempoEstimado)
    {
        $this->tiempoEstimado = intval($tiempoEstimado);
    }

    /**
     * @return int
     */
    public function getMomentoCreacion()
    {
        return $this->momentoCreacion;
    }

    /**
     * @param \DateTime $momentoCreacion
     */
    public function setMomentoCreacion($momentoCreacion)
    {
        $this->momentoCreacion = $momentoCreacion;
    }

    /**
     * @return \DateTime
     */
    public function getMomentoPreparacionInicio()
    {
        return $this->momentoPreparacionInicio;
    }

    /**
     * @param \DateTime $momentoPreparacionInicio
     */
    public function setMomentoPreparacionInicio($momentoPreparacionInicio)
    {
        $this->momentoPreparacionInicio = $momentoPreparacionInicio;
    }

    /**
     * @return \DateTime
     */
    public function getMomentoDeEntrega()
    {
        return $this->momentoDeEntrega;
    }

    /**
     * @param \DateTime $momentoDeEntrega
     */
    public function setMomentoDeEntrega($momentoDeEntrega)
    {
        $this->momentoDeEntrega = $momentoDeEntrega;
    }

    /**
     * @return EstadoPedido
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param EstadoPedido $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function isPendiente()
    {
        return boolval(EstadoPedidoEntidadDao::PENDIENTE_ID == $this->getEstado()->getId());
    }

    public function isEnPreparacion()
    {
        return boolval(EstadoPedidoEntidadDao::EN_PREPARACION_ID == $this->getEstado()->getId());
    }

    public function isParaServir()
    {
        return boolval(EstadoPedidoEntidadDao::PARA_SERVIR_ID == $this->getEstado()->getId());
    }

    public function isCancelado()
    {
        return boolval(EstadoPedidoEntidadDao::CANCELADO_ID == $this->getEstado()->getId());
    }
}