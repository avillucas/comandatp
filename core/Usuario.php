<?php

namespace Core;

use Core\Dao\AccesoDatos;
use Core\Dao\MozoEntidadDao;
use Core\Dao\PreparadorEntidadDao;
use Core\Dao\UsuarioEntidadDao;
use Core\Exceptions\SysNotFoundException;
use Core\Exceptions\SysNotImplementedException;
use Core\Exceptions\SysValidationException;
use Core\Models\UsuarioPerfiles;

class Usuario extends Entidad
{
    /** @var string $nombre */
    private $nombre;
    /** @var string $email */
    private $email;
    /** @var string $clave */
    private $clave;
    /** @var Empleado $empleado */
    private $empleado;

    public function __construct($id = null, $nombre, $email, $clave, Empleado $empleado = null)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setEmail($email);
        $this->setClave($clave);
        if (isset($empleado)) {
            $this->setEmpleado($empleado);
        }
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
     * @return Empleado
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * @param Empleado $empleado
     */
    public function setEmpleado(Empleado $empleado)
    {
        $this->empleado = $empleado;
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
     * @param $id del usuario a eliminar
     * @return bool
     * @throws SysNotFoundException
     */
    public static function borrar($id)
    {
        $id = intval($id);
        $usuario = Usuario::traerOFallar($id);
        $usuario->eliminar();
        return true;
    }

    public function __toArray()
    {
        $usuario =  ['id' => $this->id, 'email' => $this->email, 'clave' => $this->getClave(), 'nombre' => $this->getNombre()];
        if(!empty($this->getEmpleado())){
            $usuario['empledo_id'] =  $this->getEmpleado()->getId();
        }
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

        //
        if ($usuario->getClave() != Usuario::encriptar($clave)) {
            throw new SysValidationException('El password es incorrecto');
        }

        return $usuario;
    }


    public function isSocio()
    {
        return boolval(null == $this->getEmpleado());
    }

    public function isMozo()
    {
        if($this->isSocio()){
            return false;
        }
        try
        {
            $mozo = MozoEntidadDao::traerUnoPorEmpleadoId($this->getEmpleado()->getId());
        }
        catch (SysNotFoundException $e)
        {
            return false;
        }
        if (!empty($mozo) ) {
            return true;
        }
        return false;
    }

    public function isPreparador()
    {
        if($this->isSocio()){
            return false;
        }
        try
        {
            $preparador = PreparadorEntidadDao::traerUnoPorEmpleadoId($this->getEmpleado()->getId());
        }
        catch (SysNotFoundException $e)
        {
            return false;
        }
        if (!empty($preparador) ) {
            return true;
        }
        return false;
    }

    public function traerTokenPayload()
    {
        $data = $this->__toArray();
        $data['isSocio'] = $this->isSocio();
        $data['isMozo'] = $this->isMozo();
        $data['isPreparador'] = $this->isPreparador();
        return $data;
    }

}