<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 25/11/2018
 * Time: 6:02 PM
 */

namespace Core\Dao;


use Core\Entidad;
use Core\Sector;

class SectorEntidadDao extends  EntidadDao
{
    /** @var string $nombre */
    public $nombre;

    public static function insertar(Entidad $entidad)
    {
        throw new SysNotImplementedException();// insertar() method.
    }

    public static function actualizar(Entidad $entidad)
    {
        throw new SysNotImplementedException();// actualizar() method.
    }

    public static function eliminar(Entidad $entidad)
    {
        throw new SysNotImplementedException();// eliminar() method.
    }

    static function traerTodos()
    {
        throw new SysNotImplementedException();// traerTodos() method.
    }

    static function traerUno($id)
    {
       $query = 'SELECT id, nombre FROM sectores ';
       return parent::baseTraerUno(SectorEntidadDao::class,$id,$query);
    }

    public function getEntidad()
    {
        return new Sector($this->id,$this->nombre);
    }

    static function traerTodosConRelaciones()
    {
        $query = '
          SELECT s.id, s.nombre 
          FROM  sectores AS s
        ';
        return parent::queyArray($query);
    }

}