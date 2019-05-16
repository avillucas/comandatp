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

class Helado extends Entidad
{
    //A la tabla Helado, crear el campo sabor, tipo (crema o agua), kilos. (cargarlos todos los campos con valores literales).
    /** @var string $sabor */
    private $sabor;
    /** @var string $tipo */
    private $tipo;
    /** @var string $kilos */
    private $kilos;
    
    public function __construct($id = null, $tipo, $kilos,$sabor) 
    {
        $this->setId($id);
        $this->setTipo($tipo);
        $this->setKilos($kilos);                
        $this->setSabor($sabor);      
    }


    /**
     * @return string
     */
    public function getSabor()
    {
        return $this->sabor;
    }

    /**
     * @param string $sabor
     */
    public function setSabor($sabor)
    {
        $this->sabor = $sabor;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return Empleado
     */
    public function getKilos()
    {
        return $this->kilos;
    }

    public function setKilos( $kilos)
    {
        $this->kilos = $kilos;
    }

    function __toArray()
    {
       return [
           'id' => $this->getId(),
           'sabor' => $this->getSabor(),
           'kilos' => $this->getKilos(),
           'tipo' => $this->getTipo()
       ];
    }
}