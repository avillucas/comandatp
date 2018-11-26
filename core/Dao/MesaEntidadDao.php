<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 25/11/2018
 * Time: 6:25 PM
 */

namespace Core\Dao;


use Core\Entidad;
use Core\Exceptions\SysNotFoundException;
use Core\Exceptions\SysNotImplementedException;
use Core\Mesa;

class MesaEntidadDao extends  EntidadDao
{

    /** @var string $codigo */
    public $codigo ;

    /** @var EstadoMesa  */
    public $estado_id;

    public static function insertar(Entidad $entidad)
    {
        /** @var Mesa $mesa */
        $mesa = &$entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO mesas (codigo,estado_id)
            VALUES (:codigo,:estado_id)
        ");
        $consulta->bindValue(':codigo', $mesa->getCodigo(), \PDO::PARAM_STR);
        $consulta->bindValue(':estado_id', $mesa->getEstado()->getId(), \PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function actualizar(Entidad $entidad)
    {
        /** @var Mesa $mesa */
        $mesa = &$entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("
            UPDATE mesas
            SET codigo=:codigo,
              estado_id = :estadoId
            WHERE id = :id
        ");
        $consulta->bindValue(':id', $mesa->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':codigo', $mesa->getCodigo(), \PDO::PARAM_STR);
        $consulta->bindValue(':estadoId', $mesa->getEstado()->getId(), \PDO::PARAM_INT);
        $consulta->execute();

    }

    public static function eliminar(Entidad $entidad)
    {
        throw new SysNotImplementedException();// eliminar() method.
    }

    static function traerTodos()
    {
        $query  = 'SELECT id, codigo , estado_id FROM mesas ';
        return parent::baseTraerTodos(MesaEntidadDao::class,$query);
    }

    static function traerTodosConRelaciones()
    {
        $query  = '
        SELECT m.id, m.codigo , e.nombre AS estado
        FROM  mesas AS m
        JOIN  mesas_estado AS e ON e.id = m.estado_id
        ';
        return parent::queyArray($query);
    }

    static function traerUno($id)
    {
       $query  = 'SELECT id, codigo , estado_id FROM mesas ';
       return parent::baseTraerUno(MesaEntidadDao::class,$id,$query);
    }

    public static function traerUnoPorCodigo($codigo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta('SELECT id, codigo , estado_id FROM mesas WHERE codigo= :codigo');
        $consulta->bindValue(':codigo', $codigo, \PDO::PARAM_STR);
        $consulta->execute();
        /** @var EntidadDao $dao */
        $dao = $consulta->fetchObject(MesaEntidadDao::class);
        if(!$dao){
            throw  new SysNotFoundException("no existe una mesa con ese codigo");
        }
        return $dao->getEntidad();
    }

    public function getEntidad()
    {
        $estado = (isset($this->estado_id)) ? EstadoMesaEntidadDao::traerUno($this->estado_id):null;
        return new Mesa($this->id,$this->codigo, $estado);
    }


}