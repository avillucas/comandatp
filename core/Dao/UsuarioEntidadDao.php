<?php

namespace Core\Dao;

use Core\Entidad;
use Core\Exceptions\SysValidationException;
use Core\Usuario;

class UsuarioEntidadDao extends EntidadDao
{

    /** @var string $nombre */
    public $nombre;
    /** @var string $email */
    public $email;
    /** @var string $clave */
    public $clave;

    public static function crear($nombre, $email, $clave)
    {
        //crea el usuario
        $usuario = new Usuario(null, $nombre, $email, $clave);
        UsuarioEntidadDao::save($usuario);
        //
        return $usuario;
    }

    public static function insertar(Entidad $entidad)
    {
        /** @var Usuario $usuario */
        $usuario = $entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO usuarios (email,clave,nombre)
            VALUES (:email,:clave,:nombre)
        ");
        $consulta->bindValue(':email', $usuario->getEmail(), \PDO::PARAM_STR);
        $consulta->bindValue(':clave', $usuario->getClave(), \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $usuario->getNombre(), \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function actualizar(Entidad $entidad)
    {
        /** @var Usuario $usuario */
        $usuario = $entidad;
        /** @var Usuario $entidad */
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
				UPDATE usuarios 
				SET email = :email,
				clave=:clave,				
				nombre=:nombre
        		WHERE id = :id");
        $consulta->bindValue(':email', $usuario->getEmail(), \PDO::PARAM_STR);
        $consulta->bindValue(':clave', $usuario->getClave(), \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $usuario->getNombre(), \PDO::PARAM_STR);
        $consulta->bindValue(':id', $usuario->getId(), \PDO::PARAM_INT);
        return $consulta->execute();
    }

    public static function eliminar(Entidad $entidad)
    {
        /** @var Usuario $entidad */
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
				DELETE 
				FROM usuarios 				
				WHERE id=:id
        ");
        $consulta->bindValue(':id', $entidad->getId(), \PDO::PARAM_INT);
        $consulta->execute();
        return true;
    }

    /**
     * @return array|Usuario[]
     */
    public static function traerTodos()
    {
        $query = '
          SELECT s.id, s.email, s.clave , s.nombre
          FROM  usuarios AS s
        ';
        return parent::baseTraerTodos(UsuarioEntidadDao::class, $query);
    }

    public static function traerUno($id)
    {
        $query = '
          SELECT s.id, s.email, s.clave , s.nombre
          FROM  usuarios AS s
        ';
        return parent::baseTraerUno(UsuarioEntidadDao::class, $id, $query);
    }

    /**
     * @return Usuario
     */
    public function getEntidad()
    {
        $usuario = new Usuario($this->id, $this->nombre, $this->email, null);
        $usuario->setClaveEncriptada($this->clave);
        return $usuario;
    }

    /**
     * Buscar un usuario por email envia un error en caso de no exista ninguno
     * @param $email
     * @return Usuario
     * @throws SysValidationException
     */
    public static function traerUnoPorEmail($email)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("
                SELECT id, email, clave , nombre 
                FROM  usuarios 
                WHERE email = :email
               ");
        $consulta->bindValue(':email', $email, \PDO::PARAM_STR);
        $consulta->execute();
        /** @var UsuarioEntidadDao $usuarioDao */
        $usuarioDao = $consulta->fetchObject(UsuarioEntidadDao::class);
        if (!$usuarioDao) {
            throw new SysValidationException('No existe un usuario con ese email');
        }
        return $usuarioDao->getEntidad();

    }

    static function traerTodosConRelaciones()
    {
        $query = '
          SELECT s.id, s.email, s.clave , s.nombre
          FROM  usuarios AS s
        ';
        return parent::queyArray($query);
    }

}