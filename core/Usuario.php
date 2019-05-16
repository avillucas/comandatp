<?php

namespace Core;

use Core\Dao\UsuarioEntidadDao;
use Core\Exceptions\SysNotFoundException;
use Core\Exceptions\SysValidationException;

class Usuario extends Entidad
{
    /** @var string $nombre */
    private $nombre;
    /** @var string $email */
    private $email;
    /** @var string $clave */
    private $clave;

    public function __construct($id = null, $nombre, $email, $clave)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setEmail($email);
        $this->setClave($clave);
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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    public function setClaveEncriptada($clave)
    {
        $this->clave = $clave;
    }

    public function setClave($strClave)
    {
        $this->clave = Usuario::encriptar($strClave);
    }

    /**
     * @param $id
     * @return bool
     * @throws SysNotFoundException
     */
    public static function borrar($id)
    {
        $id = intval($id);
        $usuario = UsuarioEntidadDao::traerOFallar($id);
        return UsuarioEntidadDao::eliminar($usuario);
    }

    /**
     * @return array
     */
    public function __toArray()
    {
        $usuario =  ['id' => $this->id, 'email' => $this->email, 'clave' => $this->getClave(), 'nombre' => $this->getNombre()];
        return $usuario;
    }

    /**
     * Encripta un password enviado en string
     * @param $passwordString
     * @return string
     */
    protected static function encriptar($passwordString)
    {
        return md5($passwordString);
    }

    /**
     * @param $email
     * @param $clave
     * @return Usuario
     * @throws SysValidationException
     */
    public static function login($email, $clave)
    {
        $usuario = UsuarioEntidadDao::traerUnoPorEmail($email);
        if ($usuario->getClave() != Usuario::encriptar($clave)) {
            throw new SysValidationException('El password es incorrecto');
        }
        return $usuario;
    }

    public function traerTokenPayload()
    {
        return $this->__toArray();
    }

}