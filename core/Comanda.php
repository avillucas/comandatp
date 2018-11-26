<?php
namespace Core;


use Core\Exceptions\SysNotImplementedException;
use Core\Exceptions\SysValidationException;

class Comanda extends Entidad
{

    /** @var Mozo $mozo */
    private $mozo;

    /** @var Mesa $mesa */
    private  $mesa;

    /** @var string $nombre_cliente */
    private $nombre_cliente;

    /** @var string $codigo */
    private $codigo;

    /**
     * Comanda constructor.
     * @param $id
     * @param Mozo $mozo
     * @param Mesa $mesa
     * @param $nombre_cliente
     * @param null $codigo
     * @throws SysValidationException
     */
    public function __construct($id, Mozo $mozo, Mesa $mesa, $nombre_cliente, $codigo = null)
    {
        $this->setId($id);
        $this->setMozo($mozo);
        $this->setMesa($mesa);
        $this->setMozo($mozo);
        $this->setMesa($mesa);
        $this->setNombreCliente($nombre_cliente);
        if(!isset($codigo)){
            $codigo = $this->generarCodigo();
        }
        $this->setCodigo($codigo);

    }

    //TODO mejorar
    function generarCodigo()
    {
        $longitud = 5;
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
    }

    /**
     * @return Mozo
     */
    public function getMozo()
    {
        return $this->mozo;
    }

    /**
     * @param Mozo $mozo
     */
    public function setMozo($mozo)
    {
        $this->mozo = $mozo;
    }

    /**
     * @return Mesa
     */
    public function getMesa()
    {
        return $this->mesa;
    }

    /**
     * @param Mesa $mesa
     */
    public function setMesa($mesa)
    {
        $this->mesa = $mesa;
    }

    /**
     * @return string
     */
    public function getNombreCliente()
    {
        return $this->nombre_cliente;
    }

    /**
     * @param string $nombre_cliente
     */
    public function setNombreCliente($nombre_cliente)
    {
        $this->nombre_cliente = $nombre_cliente;
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
        if(strlen($codigo) !=5)
        {
            throw new SysValidationException("El codigo de mesa debe tener 5  digitos");
        }

        $this->codigo = strtolower($codigo);
    }

    public function getPedidos()
    {
        throw  new SysNotImplementedException();
    }

    public function getFoto()
    {
        throw  new SysNotImplementedException();
    }

    public function getEstado()
    {
        //revisar los estados de todos los pedidos para ver que es lo que falta
        throw  new SysNotImplementedException();
    }

    function __toArray()
    {
      $json =  [
        'id'=>$this->getId(),
        'nombreCliente' => $this->getNombreCliente(),
        //'estado' => $this->getEstado(),
        //'foto' => $this->getFoto(),
        //'pedidos' => $this->getPedidos(),
        'codigo' => $this->getCodigo(),
        'mesa' => $this->getMesa()->getCodigo()
      ];
      return $json;
    }


}