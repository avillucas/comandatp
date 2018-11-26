<?php
namespace Core\Dao;


use Core\Entidad;
use Core\EstadoPedido;
use Core\Exceptions\SysNotImplementedException;

class EstadoPedidoEntidadDao extends EntidadDao
{

    const PENDIENTE_ID = 1;
    const EN_PREPARACION_ID = 2;
    const PARA_SERVIR_ID = 3;
    const CANCELADO_ID = 4;
    /** @var int $id */
    public  $id ;
    /** @var string $nombre */
    public $nombre;


    public static function getDefault()
    {
        $estado =  EstadoPedidoEntidadDao::traerUno(EstadoPedidoEntidadDao::PENDIENTE_ID);
        if(!$estado)
        {
            throw  new SysException('No existe el estado del pedido definido como default');
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
        $query = 'SELECT id, nombre FROM pedidos_estado ';
        return parent::baseTraerUno(EstadoPedidoEntidadDao::class,$id,$query);
    }

    public function getEntidad()
    {
        return new EstadoPedido($this->id, $this->nombre);
    }

    static function traerTodosConRelaciones()
    {
        $query = '
          SELECT e.id,e.nombre 
          FROM  pedidos_estado AS e
        ';
        return parent::queyArray($query);
    }

    public static function traerPendiente()
    {
        return EstadoPedidoEntidadDao::traerUno(EstadoPedidoEntidadDao::PENDIENTE_ID);
    }

    public static function traerEnPreparacion()
    {
        return EstadoPedidoEntidadDao::traerUno(EstadoPedidoEntidadDao::EN_PREPARACION_ID);
    }

    public static function traerParaServir()
    {
        return EstadoPedidoEntidadDao::traerUno(EstadoPedidoEntidadDao::PARA_SERVIR_ID);
    }

    public static function traerCancelado()
    {
        return EstadoPedidoEntidadDao::traerUno(EstadoPedidoEntidadDao::CANCELADO_ID);
    }

}