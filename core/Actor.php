<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 25/11/2018
 * Time: 1:25 PM
 */

namespace Core;


class Actor extends Entidad
{

    /** @var string $nombre */
    private $nombre;

    /** @var string $apellido */
    private $apellido;

    /** @var string $nacionalidad */
    private $nacionalidad;

    /** @var string $fechaNacimiento */
    private $fechaNacimiento;

    /**
     * Actor constructor.
     * @param string $nombre
     * @param float $precio
     * @param int $sector_id
     */
    public function __construct($id = null, $nombre, $apellido,  $nacionalidad, $fechaNacimiento)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setNacionalidad($nacionalidad);
        $this->setFechaNacimiento($fechaNacimiento);
    }


 
    function __toArray()
    {
      return [
        'id' => $this->getId(),
        'nombre' => $this->getNombre(),
        'apellido' => $this->getApellido(),
        'nacionalidad' => $this->getNacionalidad(),
        'fechaNacimiento' => $this->getFechaNacimiento()
      ];
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
     * Get the value of apellido
     */ 
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set the value of apellido
     *
     * @return  self
     */ 
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get the value of nacionalidad
     */ 
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Set the value of nacionalidad
     *
     * @return  self
     */ 
    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    /**
     * Get the value of fechaNacimiento
     */ 
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set the value of fechaNacimiento
     *
     * @return  self
     */ 
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }
}