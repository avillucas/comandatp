<?php

namespace Core\Dao;


use Core\Encuesta;
use Core\Entidad;
use Core\Exceptions\SysNotImplementedException;

class EncuestaDao extends EntidadDao
{
    /** @var int $comanda_id */
    public $comanda_id;
    /** @var int $puntuacion_restaurante */
    public $puntuacion_restaurante = 0 ;
    /** @var int $puntuacion_mozo */
    public $puntuacion_mozo = 0 ;
    /** @var int $puntuacion_preparador */
    public $puntuacion_preparador = 0 ;
    /** @var int $puntuacion_mesa */
    public $puntuacion_mesa = 0 ;
    /** @var string $comentario */
    public $comentario = null;

    public static function insertar(Entidad $entidad)
    {
        /** @var Encuesta $encuesta */
        $encuesta = $entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO encuestas 
              (
               comanda_id, 
               puntuacion_restaurante ,
               puntuacion_mozo, 
               puntuacion_preparador,
               puntuacion_mesa,               
               comentario
               )
            VALUES (
                :comandaId, 
                :puntuacionRestaurante ,
                :puntuacionMozo, 
                :puntuacionPreparador,
                :puntuacionMesa,
                :comentario
            )
        ");
      //  var_dump( $encuesta->getPuntuacionRestaurante(),$encuesta->getPuntuacionMozo(),$encuesta->puntuacionPreparador(),$encuesta->puntuacionMesa(),$encuesta->getComentario());exit;

        $consulta->bindValue(':comandaId', $encuesta->getComanda()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionRestaurante', $encuesta->getPuntuacionRestaurante(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionMozo', $encuesta->getPuntuacionMozo(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionPreparador', $encuesta->getPuntuacionPreparador(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionMesa', $encuesta->getPuntuacionMesa(), \PDO::PARAM_INT);
        if(!empty($encuesta->getComentario())){
            $consulta->bindValue(':comentario', $encuesta->getComentario(), \PDO::PARAM_STR);
        }else{
            $consulta->bindValue(':comentario', null, \PDO::PARAM_NULL);
        }
        $consulta->execute();
        return  $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function eliminar(Entidad $entidad)
    {
        /** @var Encuesta $encuesta */
        $encuesta = &$entidad;
        /** @var Usuario $entidad */
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM encuestas WHERE id = :id");
        $consulta->bindValue(':id', $encuesta->getId(), \PDO::PARAM_INT);
        $consulta->execute();
    }

    static function traerTodos()
    {
        $query = 'SELECT id, comanda_id,puntuacion_restaurante,puntuacion_mozo,puntuacion_preparador,puntuacion_mesa,comentario FROM encuestas ';
        return parent::baseTraerTodos(EncuestaDao::class,$query);
    }

    static function traerUno($id)
    {
        $query = 'SELECT id, comanda_id,puntuacion_restaurante,puntuacion_mozo,puntuacion_preparador,puntuacion_mesa,comentario FROM encuestas ';
        return parent::baseTraerUno(EncuestaDao::class,$id,$query);
    }

    public function getEntidad()
    {
        $comanda = ComandaEntidadDao::traerUno($this->comanda_id);
        $encuesta = new Encuesta($this->id, $comanda,$this->puntuacion_mesa,$this->puntuacion_mozo,$this->puntuacion_preparador,$this->puntuacion_restaurante,$this->comentario);
        return $encuesta;
    }

    public static function actualizar(Entidad $entidad)
    {
        /** @var Encuesta $encuesta */
        $encuesta = $entidad;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        /** @var \PDOStatement $consulta */
        $consulta = $objetoAccesoDato->RetornarConsulta("
            UPDATE encuestas    
            SET          
               comanda_id = :comandaId, 
               puntuacion_restaurante = :puntuacionRestaurante ,
               puntuacion_mozo = :puntuacionMozo, 
               puntuacion_preparador = :puntuacionPreparador,
               puntuacion_mesa = :puntuacionMesa,               
               comentario = :comentario       
            WHERE id = :id
        ");
        $consulta->bindValue(':id', $encuesta->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':comandaId', $encuesta->getComanda()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionRestaurante', $encuesta->getPuntuacionRestaurante(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionMozo', $encuesta->puntuacionMozo(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionPreparador', $encuesta->puntuacionPreparador(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionMesa', $encuesta->puntuacionMesa(), \PDO::PARAM_INT);
        if(!empty($encuesta->getComentario())){
            $consulta->bindValue(':comentario', $encuesta->getComentario(), \PDO::PARAM_STR);
        }else{
            $consulta->bindValue(':comentario', null, \PDO::PARAM_NULL);
        }
        $consulta->execute();
    }

    static function traerTodosConRelaciones()
    {
        $query = 'SELECT
       e.id, 
       c.codigo AS comandaCodigo,
       e.puntuacion_restaurante,
       e.puntuacion_mozo,
       e.puntuacion_preparador,
       e.puntuacion_mesa,
       e.comentario 
      FROM encuestas AS e
      JOIN comandas AS c ON c.id = e.comanda_id
';
        return parent::queyArray($query);
    }


}