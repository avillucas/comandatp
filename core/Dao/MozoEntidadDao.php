<?php
namespace Core\Dao;

use Core\Empleado;
use Core\Entidad;
use Core\Exceptions\SysNotFoundException;
use Core\Mozo;

class MozoEntidadDao extends  EntidadDao
{
    /** @var Empleado $empleado */
    public $empleado_id;

    /**
     * @param Entidad $entidad
     * @return \Core\Empleado
     */
    public static function insertar(Entidad $entidad)
    {
        /** @var Mozo $mozo */
        $mozo = &$entidad;
        /** @var Usuario $entidad */
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO mozos (empleado_id)
            VALUES (:empleado_id)
        ");
        $consulta->bindValue(':empleado_id', $mozo->getEmpleado()->getId(), \PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
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
        $query = 'SELECT id, empleado_id FROM mozos ';
        return parent::baseTraerTodos(MozoEntidadDao::class,$query);
    }

    static function traerUno($id)
    {
        $query = 'SELECT id, empleado_id FROM mozos ';
        return parent::baseTraerUno(MozoEntidadDao::class,$id,$query);
    }

    public static function traerUnoPorEmpleadoId($empleadoId)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();        
        $consulta = $objetoAccesoDato->RetornarConsulta( 'SELECT id, empleado_id FROM mozos  WHERE empleado_id = :empleadoId');
        $consulta->bindValue(':empleadoId', $empleadoId, \PDO::PARAM_INT);
        $consulta->execute();
        /** @var EntidadDao $dao */
        $dao = $consulta->fetchObject(MozoEntidadDao::class);
        if(!$dao){
            throw  new SysNotFoundException("no existe un mozo para ese empleado");
        }
        return $dao->getEntidad();
    }

    public function getEntidad()
    {
        $empleado = EmpleadoEntidadDao::traerUno($this->empleado_id);
        return new Mozo($this->id,$empleado);
    }

    static function traerTodosConRelaciones()
    {
        $query = '
          SELECT SELECT m.id, m.empleado_id  
          FROM  mozos AS m
        ';
        return parent::queyArray($query);
    }


}