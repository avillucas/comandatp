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

class Producto extends Entidad
{
    /** @var string $id */
    public $id;
    /** @var string $tipo */
    private $tipo;
    /** @var string $descripcion */
    private $descripcion;
    /** @var string $fechaDeVencimiento */
    private $fechaDeVencimiento;
    /** @var string $precio */
    private $precio;
    /** @var string $rutaDeFoto */
    private $rutaDeFoto;
    
    public function __construct($id = null, $tipo, $descripcion,$fechaDeVencimiento, $precio,$rutaDeFoto) 
    {
        $this->setId($id);
        $this->setTipo($tipo);   
        $this->setDescripcion($descripcion);
        $this->setFechaDeVencimiento($fechaDeVencimiento);
        $this->setPrecio($precio);
        $this->setRutaDeFoto($rutaDeFoto);
    }



    function __toArray()
    {
       return [
           'id' => $this->getId(),
           'tipo' => $this->getTipo(),
           'descripcion' => $this->getDescripcion(),
           'fechaDeVencimiento' => $this->getFechaDeVencimiento(),
           'precio' => $this->getPrecio(),
           'rutaDeFoto' => $this->getRutaDeFoto()
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
     * Get the value of tipo
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */ 
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of fechaDeVencimiento
     */ 
    public function getFechaDeVencimiento()
    {
        return $this->fechaDeVencimiento;
    }

    /**
     * Set the value of fechaDeVencimiento
     *
     * @return  self
     */ 
    public function setFechaDeVencimiento($fechaDeVencimiento)
    {
        $this->fechaDeVencimiento = $fechaDeVencimiento;

        return $this;
    }

    /**
     * Get the value of precio
     */ 
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */ 
    public function setPrecio($precio)
    {
        $this->precio = floatval($precio);

        return $this;
    }

    /**
     * Get the value of rutaDeFoto
     */ 
    public function getRutaDeFoto()
    {
        return $this->rutaDeFoto;
    }

    /**
     * Set the value of rutaDeFoto
     *
     * @return  self
     */ 
    public function setRutaDeFoto($rutaDeFoto)
    {
        $this->rutaDeFoto = $rutaDeFoto;

        return $this;
    }
}