<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 25/11/2018
 * Time: 6:27 PM
 */

namespace Core\Dao;


use Core\Entidad;
use Core\EstadoMesa;
use Core\Exceptions\SysException;
use Core\Exceptions\SysNotImplementedException;

class EstadoMesaEntidadDao extends EntidadDao
{
    const CERRADA_ID = 1;
    const ESPERANDO_ID = 2;
    const COMIENDO_ID = 3;
    const PAGANDO_ID = 4;


    /** @var int $id */
    public  $id ;
    /** @var string $nombre */
    public $nombre;


    public static function getDefault()
    {
        $estado =  EstadoMesaEntidadDao::traerUno(EstadoMesaEntidadDao::CERRADA_ID);
        if(!$estado)
        {
            throw  new SysException('No existe el estado de mesa definido como default');
        }
        return $estado;
    }

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
        $query = "SELECT id,nombre FROM mesas_estado ";
        return  parent::baseTraerUno(EstadoMesaEntidadDao::class,$id,$query);
    }

    public function getEntidad()
    {
        return new EstadoMesa($this->id,$this->nombre);
    }

    static function traerTodosConRelaciones()
    {
        $query = '
          SELECT e.id,e.nombre 
          FROM  mesas_estado AS e
        ';
        return parent::queyArray($query);
    }

    public static function traerEstadoCerrado()
    {
        return EstadoMesaEntidadDao::traerUno(EstadoMesaEntidadDao::CERRADA_ID);
    }

    public static function traerEstadoEsperando()
    {
        return EstadoMesaEntidadDao::traerUno(EstadoMesaEntidadDao::ESPERANDO_ID);
    }

    public static function traerEstadoComiendo()
    {
        return EstadoMesaEntidadDao::traerUno(EstadoMesaEntidadDao::COMIENDO_ID);
    }

    public static function traerEstadoPagando()
    {
        return EstadoMesaEntidadDao::traerUno(EstadoMesaEntidadDao::PAGANDO_ID);
    }
}