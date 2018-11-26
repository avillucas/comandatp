<?php

namespace Core;

use Core\Dao\EstadoMesaEntidadDao;
use Core\Exceptions\SysValidationException;

class Mesa extends Entidad
{
    /** @var string $codigo */
    private $codigo ;

    /** @var EstadoMesa  */
    private $estado;

    /**
     * Mesa constructor.
     * @param $codigo
     * @param EstadoMesa|null $estado
     * @throws Exceptions\SysException
     * @throws SysValidationException
     */
    public function __construct($id = null, $codigo, EstadoMesa $estado = null)
    {
        $this->setId($id);
        $this->setCodigo($codigo);
        if(!isset($estado))
        {
            $estado = EstadoMesaEntidadDao::getDefault();
        }
        $this->setEstado($estado);
    }

    /**
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param $codigo
     * @throws SysValidationException
     */
    public function setCodigo($codigo)
    {
        $codigo = trim($codigo);
        if(strlen($codigo) != 5)
        {
            throw  new SysValidationException("El codigo de mesa debe tener 5 caracteres sin espacios");
        }
        $this->codigo = $codigo;
    }

    /**
     * @return EstadoMesa
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param EstadoMesa $estado
     */
    public function setEstado(EstadoMesa $estado)
    {
        $this->estado = $estado;
    }


    function __toArray()
    {
       return [
           'id' => $this->getId(),
           'codigo' => $this->getCodigo(),
           'estado' => $this->getEstado()->getNombre()
       ];
    }

    public function isCerrada()
    {
        return boolval(EstadoMesaEntidadDao::CERRADA_ID == $this->getEstado()->getId());
    }

    public function isEsperando()
    {
        return boolval(EstadoMesaEntidadDao::ESPERANDO_ID == $this->getEstado()->getId());
    }

    public function isComiendo()
    {
        return boolval(EstadoMesaEntidadDao::COMIENDO_ID == $this->getEstado()->getId());
    }

    public function isPagando()
    {
        return boolval(EstadoMesaEntidadDao::PAGANDO_ID == $this->getEstado()->getId());
    }

}