<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 10/11/2018
 * Time: 8:59 PM
 */

namespace Core\Dao;


class RegistroAccesoDao extends RegistrosDao
{

    public static function registrar($usuarioId)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO registro_acceso (usuario_id)
            VALUES (:usuarioId)
        ");
        $consulta->bindValue(':usuarioId', $usuarioId, \PDO::PARAM_INT);
        $consulta->execute();
        return  $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function reporteEmpleado(\DateTime $desde = null, \DateTime $hasta = null)
    {
        $query = 'SELECT r.id , u.nombre , r.creado
        FROM registro_acceso AS r 
        JOIN usuarios AS u  ON u.id = r.usuario_id
        ';
        $where = array();
        //
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta($query);
        $consulta->bindValue(':desde', $desde->format('Y-m-d'),\PDO::PARAM_STR);
        $consulta->bindValue(':hasta', $hasta->format('Y-m-d'),\PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }


}