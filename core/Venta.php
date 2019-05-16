<?php

namespace Core;

use Core\Dao\AccesoDatos;
use Core\Dao\MozoEntidadDao;
use Core\Dao\PreparadorEntidadDao;
use Core\Dao\UsuarioEntidadDao;
use Core\Exceptions\SysNotFoundException;
use Core\Exceptions\SysNotImplementedException;
use Core\Exceptions\SysValidationException;
use Core\Models\UsuarioPerfiles;

class Venta extends Entidad
{
    /** @var string $id */
    private $id;
    /** @var Producto $producto */
    private $producto;
    /** @var integer $cantidad */
    private $cantidad;
    /** @var string $fechaVenta */
    private $fechaVenta;
    
    public function __construct($id = null, Producto $producto, $cantidad,$fechaVenta) 
    {
        $this->setId($id);
        $this->setProducto($producto);
        $this->setCantidad($cantidad);
        $this->setFechaVenta($fechaVenta);
      
    }



    function __toArray()
    {
       return [
           'id' => $this->getId(),
           'producto' => $this->getProducto()->__toArray(),
           'cantidad' => $this->getCantidad(),
           'fechaDeVenta' => $this->getFechaVenta()           
       ];
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Get the value of producto
     */ 
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set the value of producto
     *
     * @return  self
     */ 
    public function setProducto($producto)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get the value of cantidad
     */ 
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set the value of cantidad
     *
     * @return  self
     */ 
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get the value of fechaVenta
     */ 
    public function getFechaVenta()
    {
        return $this->fechaVenta;
    }

    /**
     * Set the value of fechaVenta
     *
     * @return  self
     */ 
    public function setFechaVenta($fechaVenta)
    {
        $this->fechaVenta = $fechaVenta;

        return $this;
    }
}