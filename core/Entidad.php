<?php
namespace Core;

abstract class Entidad
{
    /** @var int $id */
    public $id = null;

    /**
     * Retorna una version en array de la entidad
     * @return array
     */
    abstract function __toArray();

    /**
     * Retorna una version en string de la entidad
     * @return string
     */
    public function __toString()
    {
        $data = array_map(function($key,$value){ return $key.':'.$value;},$this->__toArray());
        return implode(' ',$data);
    }

    /**
     * Retorna una version en json de la entidad, false si no puede convertirla
     * @return false|string
     */
    public function __toJson()
    {
        return json_encode($this->__toArray(),true);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function hasId()
    {
        return boolval(null != $this->getId());
    }



}