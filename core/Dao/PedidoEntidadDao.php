<?php
namespace Core\Dao;

use Core\Entidad;
use Core\EstadoPedido;
use Core\Exceptions\SysNotImplementedException;
use Core\Pedido;

class PedidoEntidadDao extends EntidadDao
{

    /** @var int $comanda_id */
    public $comanda_id;

    /** @var int $alimento_id */
    public $alimento_id;

    /** @var int $encargado_id */
    public $encargado_id = null;

    /** @var int $cantidad */
    public $cantidad;

    /** @var string $tiempo_estimado */
    public $tiempo_estimado = null ;

    /** @var string $momento_creacion */
    public $momento_creacion ;

    /** @var string $momento_preparacion */
    public $momento_preparacion = null;

    /** @var string $momento_de_entrega */
    public $momento_de_entrega = null;

    /** @var int $estado */
    public $estado_id;

    public static function insertar(Entidad $entidad)
    {
      /** @var Pedido $pedido */
        $pedido = &$entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $sql = "
            INSERT INTO pedidos (                                 
              comanda_id,
              alimento_id, 
              encargado_id , 
              cantidad, 
              tiempo_estimado, 
              momento_creacion,
              momento_preparacion, 
              momento_de_entrega, 
              estado_id
            )
            VALUES (                 
                    :comandaId,
                    :alimentoId,
                    :encargadoId,
                    :cantidad,
                    :tiempoEstimado,
                    :momentoCreacion,
                    :momentoPreparacion,
                    :momentoDeEntrega,
                    :estadoId
            )
        ";
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta($sql);
        $consulta->bindValue(':comandaId', $pedido->getComanda()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':alimentoId', $pedido->getAlimento()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $pedido->getCantidad(), \PDO::PARAM_INT);
        $consulta->bindValue(':estadoId', $pedido->getEstado()->getId(), \PDO::PARAM_INT);
        if(!empty($pedido->getTiempoEstimado())){
            $consulta->bindValue(':tiempoEstimado', $pedido->getTiempoEstimado(), \PDO::PARAM_INT);
        }else{
            $consulta->bindValue(':tiempoEstimado', null,\PDO::PARAM_NULL);
        }
        if(!empty($pedido->getEncargado())){
            $consulta->bindValue(':encargadoId', $pedido->getEncargado()->getId(), \PDO::PARAM_INT);
        }else{
            $consulta->bindValue(':encargadoId', null,\PDO::PARAM_NULL);
        }
        if(!empty($pedido->getMomentoCreacion())){
            $consulta->bindValue(':momentoCreacion', $pedido->getMomentoCreacion()->format('Y-m-d H:m:s'), \PDO::PARAM_STR);
        }else{
            $consulta->bindValue(':momentoCreacion', null,\PDO::PARAM_NULL);
        }
        if(!empty($pedido->getMomentoPreparacionInicio())){
            $consulta->bindValue(':momentoPreparacion', $pedido->getMomentoPreparacionInicio()->format('Y-m-d H:m:s'), \PDO::PARAM_STR);
        }else{
            $consulta->bindValue(':momentoPreparacion', null,\PDO::PARAM_NULL);
        }
        if(!empty($pedido->getMomentoDeEntrega())){
            $consulta->bindValue(':momentoDeEntrega', $pedido->getMomentoDeEntrega()->format('Y-m-d H:m:s'), \PDO::PARAM_STR);
        }else{
            $consulta->bindValue(':momentoDeEntrega', null,\PDO::PARAM_NULL);
        }
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function actualizar(Entidad $entidad)
    {
        /** @var Pedido $pedido */
        $pedido = &$entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $sql = "
            UPDATE pedidos 
            SET                                 
              comanda_id = :comandaId,
              alimento_id = :alimentoId, 
              encargado_id = :encargadoId , 
              cantidad = :cantidad, 
              tiempo_estimado = :tiempoEstimado, 
              momento_creacion = :momentoCreacion,
              momento_preparacion = :momentoPreparacion, 
              momento_de_entrega = :momentoDeEntrega, 
              estado_id = :estadoId
            WHERE id = :id;
        ";
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta($sql);
        $consulta->bindValue(':id', $pedido->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':comandaId', $pedido->getComanda()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':alimentoId', $pedido->getAlimento()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $pedido->getCantidad(), \PDO::PARAM_INT);
        $consulta->bindValue(':estadoId', $pedido->getEstado()->getId(), \PDO::PARAM_INT);
        if(!empty($pedido->getTiempoEstimado())){
            $consulta->bindValue(':tiempoEstimado', $pedido->getTiempoEstimado(), \PDO::PARAM_INT);
        }else{
            $consulta->bindValue(':tiempoEstimado', null,\PDO::PARAM_NULL);
        }
        if(!empty($pedido->getEncargado())){
            $consulta->bindValue(':encargadoId', $pedido->getEncargado()->getId(), \PDO::PARAM_INT);
        }else{
            $consulta->bindValue(':encargadoId', null,\PDO::PARAM_NULL);
        }
        if(!empty($pedido->getMomentoCreacion())){
            $consulta->bindValue(':momentoCreacion', $pedido->getMomentoCreacion()->format('Y-m-d H:m:s'), \PDO::PARAM_STR);
        }else{
            $consulta->bindValue(':momentoCreacion', null,\PDO::PARAM_NULL);
        }
        if(!empty($pedido->getMomentoPreparacionInicio())){
            $consulta->bindValue(':momentoPreparacion', $pedido->getMomentoPreparacionInicio()->format('Y-m-d H:m:s'), \PDO::PARAM_STR);
        }else{
            $consulta->bindValue(':momentoPreparacion', null,\PDO::PARAM_NULL);
        }
        if(!empty($pedido->getMomentoDeEntrega())){
            $consulta->bindValue(':momentoDeEntrega', $pedido->getMomentoDeEntrega()->format('Y-m-d H:m:s'), \PDO::PARAM_STR);
        }else{
            $consulta->bindValue(':momentoDeEntrega', null,\PDO::PARAM_NULL);
        }
        $consulta->execute();
    }

    public static function eliminar(Entidad $entidad)
    {
        throw new SysNotImplementedException();// eliminar() method.
    }

    public static function  trearPorComanda($comandaId)
    {
        $query = $query =  '
        SELECT  p.id,          
                p.encargado_id,
                p.alimento_id, 
                p.estado_id                
                p.comanda_id   
                p.cantidad, 
                p.tiempo_estimado, 
                p.momento_creacion, 
                p.momento_preparacion, 
                p.momento_de_entrega 
       FROM pedidos  AS p';
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta($query);
        $consulta->bindValue(':comandaId', $comandaId, \PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_CLASS,PedidoEntidadDao::class);
    }

    static function traerTodos()
    {
        $query =  '
        SELECT  p.id,          
                p.encargado_id,
                p.alimento_id, 
                p.estado_id  ,              
                p.comanda_id ,  
                p.cantidad, 
                p.tiempo_estimado, 
                p.momento_creacion, 
                p.momento_preparacion, 
                p.momento_de_entrega 
       FROM pedidos  AS p';
        return parent::baseTraerTodos(PedidoEntidadDao::class,$query);
    }

    static function traerUno($id)
    {
        $query =' SELECT  id,          
                encargado_id,
                alimento_id, 
                estado_id,                
                comanda_id,   
                cantidad, 
                tiempo_estimado, 
                momento_creacion, 
                momento_preparacion, 
                momento_de_entrega 
       FROM pedidos '
        ;
        return parent::baseTraerUno(PedidoEntidadDao::class,$id,$query);
    }

    public function getEntidad()
    {
        $comanda = ComandaEntidadDao::traerUno($this->comanda_id);
        $alimento = AlimentoEntidadDao::traerUno($this->alimento_id);
        $encargado = (isset($this->encargado_id)) ?  PreparadorEntidadDao::traerUno($this->encargado_id):null;
        $momentoCreacion = new \DateTime($this->momento_creacion);
        $momentoEntrega = (isset($this->momento_de_entrega)) ? new \DateTime($this->momento_de_entrega):null;
        $momentoPreparacion =(isset($this->momento_preparacion)) ?  new \DateTime($this->momento_preparacion):null;
        $estado = (isset($this->estado_id)) ? EstadoPedidoEntidadDao::traerUno($this->estado_id):null;
        $pedido = new Pedido($this->id,$comanda,$alimento,$encargado,$this->cantidad,$this->tiempo_estimado,$momentoCreacion,$momentoPreparacion,$momentoEntrega,$estado);
        return $pedido;
    }

    static function traerTodosConRelaciones()
    {
        $query = '
         SELECT  
                p.id,          
                p.encargado_id,
                a.nombre AS alimento, 
                pe.nombre AS estado,                               
                c.codigo  AS comanda,
                p.cantidad, 
                p.tiempo_estimado, 
                p.momento_creacion, 
                p.momento_preparacion, 
                p.momento_de_entrega 
         FROM pedidos as p
         LEFT JOIN  preparadores as pre ON pre.id = p.encargado_id
         JOIN alimentos as a ON a.id = p.alimento_id
         JOIN comandas as c ON c.id = p.comanda_id
         JOIN  pedidos_estado as pe ON pe.id = p.estado_id 
        ';
        return parent::queyArray($query);
    }



    static function traerTodasLasPendientePorSector($sectorId)
    {
        $query = '
         SELECT  
                p.id,          
                p.encargado_id,
                a.nombre AS alimento, 
                pe.nombre AS estado,                               
                c.codigo  AS comanda,
                p.cantidad, 
                p.tiempo_estimado, 
                p.momento_creacion, 
                p.momento_preparacion, 
                p.momento_de_entrega 
         FROM pedidos as p
         LEFT JOIN  preparadores as pre ON pre.id = p.encargado_id
         JOIN alimentos as a ON a.id = p.alimento_id
         JOIN comandas as c ON c.id = p.comanda_id
         JOIN  pedidos_estado as pe ON pe.id = p.estado_id 
         WHERE p.estado_id = :estadoPedidoId
         AND a.sector_id = :sectorId
         ORDER BY momento_creacion DESC
        ';
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta($query);
        $consulta->bindValue(':estadoPedidoId', EstadoPedidoEntidadDao::PENDIENTE_ID, \PDO::PARAM_INT);
        $consulta->bindValue(':sectorId', $sectorId, \PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }


    static function traerTodasLasPendienteDelMozo($mozoId)
    {
        $query = '
         SELECT  
                p.id,          
                p.encargado_id,
                a.nombre AS alimento, 
                pe.nombre AS estado,                               
                c.codigo  AS comanda,
                p.cantidad, 
                p.tiempo_estimado, 
                p.momento_creacion, 
                p.momento_preparacion, 
                p.momento_de_entrega 
         FROM pedidos as p
         LEFT JOIN  preparadores as pre ON pre.id = p.encargado_id
         JOIN alimentos as a ON a.id = p.alimento_id
         JOIN comandas as c ON c.id = p.comanda_id
         JOIN  pedidos_estado as pe ON pe.id = p.estado_id 
         WHERE p.estado_id = :estadoPedidoId
         AND c.mozo_id = :mozoId
         ORDER BY momento_creacion DESC
        ';
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta($query);
        $consulta->bindValue(':estadoPedidoId', EstadoPedidoEntidadDao::PENDIENTE_ID, \PDO::PARAM_INT);
        $consulta->bindValue(':mozoId', $mozoId, \PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }

    static function traerParaServirDelMozo($mozoId)
    {
        $query = '
         SELECT  
                p.id,          
                p.encargado_id,
                a.nombre AS alimento, 
                pe.nombre AS estado,                               
                c.codigo  AS comanda,
                p.cantidad, 
                p.tiempo_estimado, 
                p.momento_creacion, 
                p.momento_preparacion, 
                p.momento_de_entrega 
         FROM pedidos as p
         LEFT JOIN  preparadores as pre ON pre.id = p.encargado_id
         JOIN alimentos as a ON a.id = p.alimento_id
         JOIN comandas as c ON c.id = p.comanda_id
         JOIN  pedidos_estado as pe ON pe.id = p.estado_id 
         WHERE p.estado_id = :estadoParaServir
         AND c.mozo_id = :mozoId
         ORDER BY momento_de_entrega DESC
        ';
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta($query);
        $consulta->bindValue(':estadoParaServir', EstadoPedidoEntidadDao::PARA_SERVIR_ID, \PDO::PARAM_INT);
        $consulta->bindValue(':mozoId', $mozoId, \PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }
}