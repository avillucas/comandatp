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
               comanda_id, puntuacion_restaurante ,puntuacion_mozo, puntuacion_preparador,puntuacion_mesa,puntuacion_restaurante,comentario
               )
            VALUES (
                    :comandaId, 
                    :puntuacionRestaurante ,
                    :puntuacionMozo, 
                    :puntuacionPreparador,
                    :puntuacionMesa,
                    :puntuacionRestaurante,
                    :comentario
                    )
        ");
        $consulta->bindValue(':comandaId', $encuesta->getComanda()->getId(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionRestaurante', $encuesta->puntuacionRestaurante(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionMozo', $encuesta->puntuacionMozo(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionPreparador', $encuesta->puntuacionPreparador(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionMesa', $encuesta->puntuacionMesa(), \PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionRestaurante', $encuesta->puntuacionRestaurante(), \PDO::PARAM_INT);
        if(!empty($encuesta->getComentario())){
            $consulta->bindValue(':comentario', $encuesta->isActivo(), \PDO::PARAM_STR);
        }
        else
        {
            $consulta->bindValue(':comentario', null, \PDO::PARAM_NULL);
        }


        $consulta->execute();
        return  $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function actualizar(Entidad $entidad)
    {
        throw  new SysNotImplementedException();
    }

    public static function eliminar(Entidad $entidad)
    {
        throw  new SysNotImplementedException();
    }

    static function traerTodos()
    {
        throw  new SysNotImplementedException();
    }

    static function traerTodosConRelaciones()
    {
        throw  new SysNotImplementedException();
    }

    static function traerUno($id)
    {
        throw  new SysNotImplementedException();
    }

    public function getEntidad()
    {
        $comanda = ComandaEntidadDao::traerUno($this->comanda_id);
        $encuesta = new Encuesta($this->id, $comanda,$this->puntuacion_mesa,$this->puntuacion_mozo,$this->puntuacion_preparador,$this->puntuacion_restaurante,$this->comentario);
        return $encuesta;
    }


}