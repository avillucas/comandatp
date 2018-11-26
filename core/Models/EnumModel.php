<?php
namespace Core\Models;


use Core\Exceptions\SysNotFoundException;

abstract class EnumModel
{
    abstract static function getDefault();

    public static function __toArray()
    {
        return static::getTiles();
    }

    abstract static function getNames();

    public static function toString($separator=',')
    {
        return implode($separator,static::__toArray());
    }

    public static function exists($code)
    {
        $names = static::getNames();
        return (isset( $names[$code]));
    }


    public static function getName( $code)
    {
        if(!static::exists($code))
        {
            throw new SysNotFoundException('El codigo '.$code.' no existe');
        }
        $names = static::getNames();
        return  $names[$code];
    }

    public static function existsOFallar($code)
    {
        if(!static::exists($code))
        {
            throw new SysNotFoundException('El codigo '.$code.' no existe');
        }
    }
}