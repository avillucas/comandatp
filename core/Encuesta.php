<?php

namespace Core;


class Encuesta extends Entidad
{

    /** @var Comanda $comanda */
    public $comanda;
    /** @var int $puntuacionRestaurante */
    public $puntuacionRestaurante = 0 ;
    /** @var int $puntuacionMozo */
    public $puntuacionMozo = 0 ;
    /** @var int $puntuacionPreparador */
    public $puntuacionPreparador = 0 ;
    /** @var int $puntuacionMesa */
    public $puntuacionMesa = 0 ;
    /** @var string $comentario */
    public $comentario = null;

    /**
     * Encuesta constructor.
     * @param Comanda $comanda
     * @param int $puntuacionRestaurante
     * @param int $puntuacionMozo
     * @param int $puntuacionPreparador
     * @param int $puntuacionMesa
     * @param string $comentario
     */
    public function __construct($id, Comanda $comanda, $puntuacionRestaurante, $puntuacionMozo, $puntuacionPreparador, $puntuacionMesa, $comentario)
    {
        $this->setId($id);
        $this->setComanda($comanda);
        $this->setPuntuacionMesa($puntuacionMesa);
        $this->setPuntuacionMozo($puntuacionMozo);
        $this->setPuntuacionPreparador($puntuacionPreparador);
        $this->setPuntuacionRestaurante($puntuacionRestaurante);
        $this->setComentario($comentario);
    }

    /**
     * @return Comanda
     */
    public function getComanda()
    {
        return $this->comanda;
    }

    /**
     * @param Comanda $comanda
     */
    public function setComanda($comanda)
    {
        $this->comanda = $comanda;
    }

    /**
     * @return int
     */
    public function getPuntuacionRestaurante()
    {
        return $this->puntuacionRestaurante;
    }

    /**
     * @param int $puntuacionRestaurante
     */
    public function setPuntuacionRestaurante($puntuacionRestaurante)
    {
        $this->puntuacionRestaurante = $puntuacionRestaurante;
    }

    /**
     * @return int
     */
    public function getPuntuacionMozo()
    {
        return $this->puntuacionMozo;
    }

    /**
     * @param int $puntuacionMozo
     */
    public function setPuntuacionMozo($puntuacionMozo)
    {
        $this->puntuacionMozo = $puntuacionMozo;
    }

    /**
     * @return int
     */
    public function getPuntuacionPreparador()
    {
        return $this->puntuacionPreparador;
    }

    /**
     * @param int $puntuacionPreparador
     */
    public function setPuntuacionPreparador($puntuacionPreparador)
    {
        $this->puntuacionPreparador = $puntuacionPreparador;
    }

    /**
     * @return int
     */
    public function getPuntuacionMesa()
    {
        return $this->puntuacionMesa;
    }

    /**
     * @param int $puntuacionMesa
     */
    public function setPuntuacionMesa($puntuacionMesa)
    {
        $this->puntuacionMesa = $puntuacionMesa;
    }

    /**
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param string $comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }


    function __toArray()
    {
        return [
            'id' => $this->getId(),
            'comanda' => $this->getComanda()->getCodigo(),
            'mesa' => $this->getPuntuacionMesa(),
            'mozo' => $this->getPuntuacionMozo(),
            'preparador' => $this->getPuntuacionPreparador(),
            'restaurante' => $this->getPuntuacionRestaurante(),
            'comentario'=>$this->getComentario(),

        ];
    }


}