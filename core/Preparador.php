<?php
namespace Core;


class Preparador extends Entidad
{
    /** @var Sector $sector */
    private $sector;

    /** @var Empleado $empleado */
    private $empleado;

    /**
     * Preparador constructor.
     * @param Sector $sector
     */
    public function __construct($id = null, Empleado $empleado, Sector $sector)
    {
        $this->setId($id);
        $this->setEmpleado($empleado);
        $this->setSector($sector);
    }

    /**
     * @return Empleado
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * @param Empleado $empleado
     */
    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;
    }

    /**
     * @return Sector
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * @param Sector $sector
     */
    public function setSector( Sector $sector)
    {
        $this->sector = $sector;
    }

    function __toArray()
    {
        $json =  [
            'id'=>$this->getId(),
            'activo' => $this->getEmpleado()->isActivo(),
            'sector' => $this->getSector()->getNombre(),
            'activo' => $this->getEmpleado()->isActivo(),
        ];
        return $json;
    }

}