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

class Pelicula extends Entidad
{
     
    /** @var string $nombre */
    private $nombre;
    /** @var string $tipo */
    private $tipo;
    /** @var Date $fechaEstreno */
    private $fechaEstreno;    
    /** @var int $cantidadPublico */
    private $cantidadPublico;
    /** @var string $foto */
    private $foto;
    /** @var int $actor */
    private $actor;


    public function __construct($id = null, $nombre, $tipo,$fechaEstreno,$cantidadPublico,$foto=null,$actor=null) 
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setTipo($tipo);
        $this->setFechaEstreno($fechaEstreno);
        $this->setCantidadPublico($cantidadPublico);
        $this->setFoto($foto);
        $this->setActor($actor);
    }
 

    function __toArray()
    {
       return [
           'id' => $this->getId(),
           'nombre' => $this->getNombre(),
           'tipo' => $this->getTipo(),
           'fechaEstreno' => $this->getFechaEstreno(),
           'foto' => $this->getFoto(),
           'cantidadPublico' => $this->getCantidadPublico(),
           'actor' => $this->getActor()
       ];
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
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of cantidadPublico
     */ 
    public function getCantidadPublico()
    {
        return $this->cantidadPublico;
    }

    /**
     * Set the value of cantidadPublico
     *
     * @return  self
     */ 
    public function setCantidadPublico($cantidadPublico)
    {
        $this->cantidadPublico = $cantidadPublico;

        return $this;
    }

    /**
     * Get the value of foto
     */ 
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set the value of foto
     *
     * @return  self
     */ 
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get the value of fechaEstreno
     */ 
    public function getFechaEstreno()
    {
        return $this->fechaEstreno;
    }

    /**
     * Set the value of fechaEstreno
     *
     * @return  self
     */ 
    public function setFechaEstreno($fechaEstreno)
    {
        $this->fechaEstreno = $fechaEstreno;

        return $this;
    }

    /**
     * Get the value of actor
     */ 
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * Set the value of actor
     *
     * @return  self
     */ 
    public function setActor($actor)
    {
        $this->actor = $actor;

        return $this;
    }
}