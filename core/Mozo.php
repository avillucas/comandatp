<?php

namespace Core;


use Core\Dao\EmpleadoEntidadDao;

class Mozo extends  Entidad
{
    /** @var Empleado $empleado */
    private $empleado;

    /**
     * Mozo constructor.
     */
    public function __construct($id=null,Empleado $empleado)
    {
        $this->setId($id);
        $this->setEmpleado($empleado);
    }

    public function isActivo()
    {
        return $this->empleado->isActivo();
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

    function __toArray()
    {
      return ['id'=>$this->getId(), 'activo' => $this->getEmpleado()->isActivo()];
    }

}