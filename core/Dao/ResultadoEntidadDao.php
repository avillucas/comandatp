<?php

namespace Core\Dao;

use Core\Entidad;
use Core\Exceptions\SysValidationException;
use Core\Usuario;
use Core\Resultado;

class ResultadoEntidadDao extends EntidadDao
{

    /** @var boolean $gano */
    public $gano;
    /** @var string $juego */
    public $juego;
    /** @var Usuario $usuario */
    public $usuario;

    public static function crear($gano,  $juego,Usuario $usuario)
    {
        //crea el usuario
        $resultado = new Resultado(null, $gano, $juego,$usuario);
        ResultadoEntidadDao::save($resultado);
        //
        return $resultado;
    }

    public static function insertar(Entidad $entidad)
    {
        /** @var Resultado $resultado */
        $resultado = $entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO resultados (gano,usuario_id,juego)
            VALUES (:gano,:usuario,:juego)
        ");
        $consulta->bindValue(':gano', $resultado->isGano(), \PDO::PARAM_BOOL);
        $consulta->bindValue(':usuario', $resultado->getUsuario()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':juego', $resultado->getJuego(), \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function actualizar(Entidad $entidad)
    {
        /** @var Resultado $resultado */
        $resultado = $entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
				UPDATE resultados 
				SET juego = :juego,
				usuario_id=:usuario,				
				gano=:gano
        		WHERE id = :id");
        $consulta->bindValue(':gano', $resultado->isGano(), \PDO::PARAM_BOOL);
        $consulta->bindValue(':usuario', $resultado->getUsuario()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':juego', $resultado->getJuego(), \PDO::PARAM_STR);
        $consulta->bindValue(':id', $resultado->getId(), \PDO::PARAM_INT);
        return $consulta->execute();
    }

    public static function eliminar(Entidad $entidad)
    {
        /** @var Usuario $entidad */
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
				DELETE 
				FROM resultados 				
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
          SELECT r.id, r.gano, r.juego, r.time , r.usuario_id AS usuarioId
          FROM  resultados AS r
        ';
        return parent::baseTraerTodos(UsuarioEntidadDao::class, $query);
    }

    public static function traerUno($id)
    {
        $query = '
          SELECT r.id, r.gano, r.juego, r.time , r.usuario_id AS usuarioId
          FROM  resultados AS r
        ';
        return parent::baseTraerUno(UsuarioEntidadDao::class, $id, $query);
    }

    /**
     * @return Resultado
     */
    public function getEntidad()
    {
        return new Resultado($this->id, $this->gano, $this->email, $this->usuario);
    }

    static function traerTodosConRelaciones()
    {
        $query = '
          SELECT r.id, r.gano, r.juego, r.time , r.usuario_id AS usuarioId
          FROM  resultados AS r
        ';
        return parent::queyArray($query);
    }

}