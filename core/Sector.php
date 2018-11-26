<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 25/11/2018
 * Time: 1:24 PM
 */

namespace Core;


class Sector
{

    /** @var int $nombre */
    public $id;

    /** @var string $nombre */
    public $nombre;

    /**
     * Sector constructor.
     * @param string $nombre
     */
    public function __construct($id,$nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre) ;
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
    public function setNombre($nombre)
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