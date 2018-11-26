<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 26/11/2018
 * Time: 11:29 AM
 */

namespace Core\Dao;


use Core\Entidad;
use Core\Exceptions\SysNotImplementedException;

class SocioEntidadDao extends EntidadDao
{
    public static function insertar(Entidad $entidad)
    {
        throw new SysNotImplementedException();
    }

    public static function actualizar(Entidad $entidad)
    {
        throw new SysNotImplementedException();
    }

    public static function eliminar(Entidad $entidad)
    {
        throw new SysNotImplementedException();
    }

    static function traerTodos()
    {
        throw new SysNotImplementedException();
    }

    static function traerTodosConRelaciones()
    {
        throw new SysNotImplementedException();
    }

    static function traerUno($id)
    {
        throw new SysNotImplementedException();
    }

    public function getEntidad()
    {
        throw new SysNotImplementedException();
    }


}