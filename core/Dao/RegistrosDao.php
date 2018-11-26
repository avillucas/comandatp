<?php

namespace Core\Dao;


abstract class RegistrosDao
{

    protected function queryArray($query)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta($query);
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }
}