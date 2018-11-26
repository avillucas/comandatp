<?php
namespace Core\Dao;


use Core\Comanda;
use Core\Entidad;

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
        throw new SysNotImplementedException();// actualizar() method.
    }

    public static function eliminar(Entidad $entidad)
    {
        throw new SysNotImplementedException();// eliminar() method.
    }

    static function traerTodos()
    {
        $query  = 'SELECT id, codigo , mozo_id,mesa_id FROM  comandas ';
        return parent::baseTraerTodos(ComandaEntidadDao::class,$query);
    }

    static function traerUno($id)
    {
        $query  = 'SELECT id, codigo , mozo_id,mesa_id FROM  comandas ';
        return parent::baseTraerUno(ComandaEntidadDao::class,$id,$query);
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
          SELECT c.id, c.codigo , m.nombre as mozo ,me.codigo as mesa 
          FROM  comandas AS c 
          JOIN mozos AS mo  ON mo.id = c.mozo_id
          JOIN mesas AS me  ON me.id = c.mesa_id
        ';
         return parent::queyArray($query);
    }


}