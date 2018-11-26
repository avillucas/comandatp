<?php
namespace Core\Dao;


use Core\Comanda;
use Core\Entidad;
use Core\Exceptions\SysNotFoundException;

class ComandaEntidadDao extends EntidadDao
{
    /** @var int $mozo_id */
    public $mozo_id;

    /** @var int $mesa_id */
    public  $mesa_id;

    /** @var string $nombre_cliente */
    public $nombre_cliente;

    /** @var string $codigo */
    public $codigo;

    public static function insertar(Entidad $entidad)
    {
        /** @var Comanda $comanda */
        $comanda = &$entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO comandas (mozo_id,mesa_id, nombre_cliente, codigo)
            VALUES (:mozoId,:mesaId,:nombreCliente,:codigo)
        ");
        $consulta->bindValue(':mozoId', $comanda->getMozo()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':mesaId', $comanda->getMesa()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':nombreCliente', $comanda->getNombreCliente(), \PDO::PARAM_STR);
        $consulta->bindValue(':codigo', $comanda->getCodigo(), \PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function actualizar(Entidad $entidad)
    {
        /** @var Comanda $comanda */
        $comanda = &$entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("
            UPDATE comandas 
            SET 
                mozo_id = :mozoId,
                mesa_id = :mesaId, 
                nombre_cliente = :nombreCliente, 
                codigo = :codigo            
            WHERE id = :id
        ");
        $consulta->bindValue(':mozoId', $comanda->getMozo()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':mesaId', $comanda->getMesa()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':nombreCliente', $comanda->getNombreCliente(), \PDO::PARAM_STR);
        $consulta->bindValue(':codigo', $comanda->getCodigo(), \PDO::PARAM_STR);
        $consulta->bindValue(':id', $comanda->getId(), \PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function eliminar(Entidad $entidad)
    {
        /** @var Comanda $comanda */
        $comanda = &$entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM comandas WHERE id = :id");
        $consulta->bindValue(':id', $comanda->getId(), \PDO::PARAM_INT);
        $consulta->execute();
    }

    static function traerTodos()
    {
        $query  = 'SELECT id, codigo ,nombre_cliente, mozo_id,mesa_id FROM  comandas ';
        return parent::baseTraerTodos(ComandaEntidadDao::class,$query);
    }

    static function traerUno($id)
    {
        $query  = 'SELECT id, codigo,nombre_cliente, mozo_id,mesa_id FROM  comandas ';
        return parent::baseTraerUno(ComandaEntidadDao::class,$id,$query);
    }

    static function traerUnoPorCodigo($codigo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta('SELECT id, codigo,nombre_cliente, mozo_id,mesa_id FROM  comandas WHERE codigo = :codigo ');
        $consulta->bindValue(':codigo', $codigo, \PDO::PARAM_INT);
        $consulta->execute();
        /** @var EntidadDao $dao */
        $dao = $consulta->fetchObject(ComandaEntidadDao::class);
        if(!$dao)
        {
            throw new SysNotFoundException("La entidad (".$codigo.") buscada no existe");
        }
        return $dao->getEntidad();
    }

    public function getEntidad()
    {
        $mozo = MozoEntidadDao::traerUno($this->mozo_id);
        $mesa = MesaEntidadDao::traerUno($this->mesa_id);
        $comanda = new Comanda($this->id,$mozo,$mesa,$this->nombre_cliente,$this->codigo);
       return $comanda;
    }

    static function traerTodosConRelaciones()
    {
        $query = '
          SELECT c.id, c.codigo , c.nombre_cliente ,u.nombre as mozo ,me.codigo as mesa 
          FROM  comandas AS c 
          JOIN mozos AS mo  ON mo.id = c.mozo_id            
          JOIN usuarios AS u  ON u.empleado_id = mo.empleado_id
          JOIN mesas AS me  ON me.id = c.mesa_id
        ';
         return parent::queyArray($query);
    }


}