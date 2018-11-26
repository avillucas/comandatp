<?php
namespace Core\Dao;


use Core\Entidad;
use Core\Exceptions\SysNotFoundException;
use Core\Preparador;
use mysql_xdevapi\Exception;

class PreparadorEntidadDao extends  EntidadDao
{
    /** @var int $empleado_id */
    public  $empleado_id ;
    /** @var int $sector_id */
    public  $sector_id ;

    public static function insertar(Entidad $entidad)
    {
        /** @var Preparador $preparador */
        $preparador = &$entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO preparadores (empleado_id,sector_id)
            VALUES (:empleado_id,:sector_id)
        ");
        $consulta->bindValue(':empleado_id', $preparador->getEmpleado()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':sector_id', $preparador->getSector()->getId(), \PDO::PARAM_INT);
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
        $query = 'SELECT id, empleado_id,sector_id  FROM preparadores ';
        return parent::baseTraerTodos(PreparadorEntidadDao::class,$query);
    }

    static function traerUno($id)
    {
        $query = 'SELECT id, empleado_id,sector_id  FROM preparadores ';
        return parent::baseTraerUno(PreparadorEntidadDao::class,$id,$query);
    }

    public static function traerUnoPorEmpleadoId($empleadoId)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta( 'SELECT id, empleado_id, sector_id FROM preparadores  WHERE empleado_id = :empleadoId');
        $consulta->bindValue(':empleadoId', $empleadoId, \PDO::PARAM_INT);
        $consulta->execute();
        /** @var EntidadDao $dao */
        $dao = $consulta->fetchObject(PreparadorEntidadDao::class);
        if(!$dao){
            throw  new SysNotFoundException("no existe un preparador para ese empleado");
        }
        return $dao->getEntidad();
    }

    public function getEntidad()
    {
        $empleado = EmpleadoEntidadDao::traerUno($this->empleado_id);
        $sector = SectorEntidadDao::traerUno($this->sector_id);
        return new Preparador($this->id,$empleado,$sector);
    }

    static function traerTodosConRelaciones()
    {
        $query = '
          SELECT p.id, p.empleado_id, s.nombre AS sector 
          FROM  preparadores AS p
          JOIN sectores AS s ON s.id = p.sector_id
        ';
        return parent::queyArray($query);
    }


}