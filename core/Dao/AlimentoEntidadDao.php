<?php
namespace Core\Dao;

use Core\Alimento;
use Core\Entidad;
use Core\Exceptions\SysNotImplementedException;

class AlimentoEntidadDao extends  EntidadDao
{

    /** @var string $nombre */
    public $nombre;

    /** @var float $precio */
    public $precio;

    /** @var int $sector_id */
    public $sector_id;


    public static function insertar(Entidad $entidad)
    {
        /** @var Alimento $alimento */
        $alimento = &$entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO alimentos (nombre,precio,sector_id)
            VALUES (:nombre,:precio,:sector_id)
        ");
        $consulta->bindValue(':nombre', $alimento->getNombre(), \PDO::PARAM_STR);
        $consulta->bindValue(':precio', $alimento->getPrecio(), \PDO::PARAM_STR);
        $consulta->bindValue(':sector_id', $alimento->getSector()->getId(), \PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function actualizar(Entidad $entidad)
    {
        /** @var Alimento $alimento */
        $alimento = &$entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("
            UPDATE alimentos
             SET 
                 nombre = :nombre ,
                 precio =  :precio,
                 sector_id = :sector_id 
            WHERE id = :id
        ");
        $consulta->bindValue(':nombre', $alimento->getNombre(), \PDO::PARAM_STR);
        $consulta->bindValue(':precio', $alimento->getPrecio(), \PDO::PARAM_STR);
        $consulta->bindValue(':sector_id', $alimento->getSector()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':id', $alimento->getId(), \PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function eliminar(Entidad $entidad)
    {
        /** @var Alimento $alimento */
        $alimento = &$entidad;
        /** @var Usuario $entidad */
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM alimentos WHERE id = :id");
        $consulta->bindValue(':id', $alimento->getId(), \PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    static function traerTodos()
    {
        $query  = 'SELECT id, nombre , precio , sector_id FROM  alimentos ';
        return parent::baseTraerTodos(AlimentoEntidadDao::class,$query);
    }

    static function traerTodosConRelaciones()
    {
        $query  = '
        SELECT a.id, a.nombre , a.precio , s.nombre AS sector
        FROM  alimentos AS a
        JOIN  sectores AS s ON s.id = a.sector_id
        ';
        return parent::queyArray($query);
    }


    static function traerUno($id)
    {
        $query  = 'SELECT id, nombre , precio , sector_id FROM  alimentos ';
        return parent::baseTraerUno(AlimentoEntidadDao::class,$id,$query);
    }

    public function getEntidad()
    {
        $sector = SectorEntidadDao::traerUno($this->sector_id);
        return new Alimento($this->id,$this->nombre,$this->precio,$sector);
    }

    public static function collectionMap(AlimentoEntidadDao $alimento)
    {
      return $alimento->getEntidad()->__toArray();
    }

}