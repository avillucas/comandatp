<?php

namespace Core;

class Resultado extends Entidad
{
    /** @var boolean $gano */
    private $gano;
    /** @var string $juego */
    private $juego;
    /** @var Usuario $usuario */
    private $usuario;

    public function __construct($id = null, $gano, $juego, Usuario $usuario)
    {
        $this->setId($id);
        $this->setGano($gano);
        $this->setJuego($juego);
        $this->setUsuario($usuario);
    }

    /**
     * @return bool
     */
    public function isGano()
    {
        return $this->gano;
    }

    /**
     * @param bool $gano
     */
    public function setGano($gano)
    {
        $this->gano = $gano;
    }

    /**
     * @return string
     */
    public function getJuego()
    {
        return $this->juego;
    }

    /**
     * @param string $juego
     */
    public function setJuego($juego)
    {
        $this->juego = $juego;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return array
     */
    public function __toArray()
    {
        return   ['id' => $this->id, 'gano' => $this->gano, 'juego' => $this->juego,'usuarioId'=>$this->usuario->getId()];
    }

}