<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 4/11/2018
 * Time: 5:54 PM
 */

namespace Core\Models;


class UsuarioPerfiles extends EnumModel
{
    const EMPLEADO = 'E';
    const SOCIO = 'S';

    private static $names =[
      self::EMPLEADO => 'empleado',
      self::SOCIO => 'socio',
    ];

    static function getDefault()
    {
        return self::EMPLEADO;
    }

    static function getNames()
    {
      return self::$names;
    }


}