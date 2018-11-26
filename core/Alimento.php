<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 25/11/2018
 * Time: 1:25 PM
 */

namespace Core;


class Alimento extends Entidad
{

    /** @var string $nombre */
    private $nombre;

    /** @var float $precio */
    private $precio;

    /** @var Sector $sector */
    private $sector;

    /**
     * Alimento constructor.
     * @param string $nombre
     * @param float $precio
     * @param int $sector_id
     */
    public function __construct($id = null, $nombre, $precio, Sector $sector)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setPrecio($precio);
        $this->setSector($sector);
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
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param float $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = floatval($precio);
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
      return [
        'id' => $this->getId(),
        'nombre' => $this->getNombre(),
        'precio' => $this->getPrecio(),
        'sector' => $this->getSector()->getNombre()
      ];
    }


}