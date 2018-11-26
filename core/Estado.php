<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 25/11/2018
 * Time: 1:05 PM
 */

namespace Core;


abstract class Estado
{

    /** @var int $id */
    protected  $id ;
    /** @var string $nombre */
    protected $nombre;

    /**
     * Estado constructor.
     * @param string $nombre
     */
    public function __construct($id = null,$nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    protected function setNombre($nombre)
    {
        $this->nombre = $nombre;
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

}