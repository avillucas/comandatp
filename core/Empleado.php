<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 25/11/2018
 * Time: 1:49 PM
 */

namespace Core;


class Empleado extends Entidad
{
   /** @var bool $activo */
    private $activo ;

    /**
     * Empleado constructor.
     * @param bool $activo
     */
    public function __construct($id=null, $activo = true)
    {
        $this->setId($id);
        $this->activo = $activo;
    }

    /**
     * @return bool
     */
    public function isActivo()
    {
        return $this->activo;
    }

    /**
     * @param bool $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * @return array
     */
    public function __toArray()
    {
      return [ 'id' => $this->getId(), 'activo' => $this->isActivo()];
    }

}