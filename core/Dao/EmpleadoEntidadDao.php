<?php
namespace Core\Dao;


use Core\Empleado;
use Core\Entidad;
use Core\Exceptions\SysException;
use Core\Exceptions\SysNotImplementedException;

class EmpleadoEntidadDao extends EntidadDao
{
     /** @var bool $activo */
    public $activo  ;

    /**
     * @param Entidad $entidad
     * @return Empleado
     */
    public static function insertar(Entidad $entidad)
    {
        /** @var Empleado $empleado */
        $empleado = $entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO empleados (activo)
            VALUES (:activo)
        ");
        $consulta->bindValue(':activo', $empleado->isActivo(), \PDO::PARAM_INT);
        $consulta->execute();
        return  $objetoAccesoDato->RetornarUltimoIdInsertado();
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
        $query = "SELECT id, activo FROM empleados ";
        return parent::baseTraerUno(EmpleadoEntidadDao::class,$id,$query);
    }


    public function getEntidad()
    {
      return new Empleado($this->id,boolval($this->activo));
    }

    static function traerTodosConRelaciones()
    {
        $query = '
          SELECT  e.id, e.activo  
          FROM  empleados AS e
        ';
        return parent::queyArray($query);
    }


}