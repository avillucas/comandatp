<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 4/11/2018
 * Time: 7:03 PM
 */

namespace Core\Models;


use Core\Entidad;

class Langs extends EnumModel
{
    const MODIFICADO_OK = 'modificado';
    const CREADO_OK = 'creado';
    const ELIMINADO_OK = 'eliminado';
    const ACCESO_DENEGADO = 'denegado';
    const INVALID = 'invalid';

    const PERDIDO = 'perdido';

    private static  $names = [
        self::CREADO_OK => 'Se creo correctamente',
        self::MODIFICADO_OK => 'Se modifico correctamente',
        self::ELIMINADO_OK => 'Fue eliminado',
        self::ACCESO_DENEGADO => 'No posee permiso para realizar la accion',
        self::PERDIDO => 'El recurso que busca no existe',
        self::INVALID => 'Los datos ingresados no son correctos',
    ];

    static function getDefault()
    {
        return self::CREADO_OK;
    }

    static function getNames()
    {
        return self::$names;
    }

    public static function getModificadoText(Entidad $entidad = null)
    {

        return static::getName(self::MODIFICADO_OK);
    }


    public static function getCreadoText(Entidad $entidad = null)
    {
        return static::getName(self::CREADO_OK);
    }

    public static function getEliminadoText(Entidad $entidad = null)
    {
        return self::getName(self::ELIMINADO_OK);
    }

}