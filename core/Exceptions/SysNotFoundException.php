<?php
namespace Core\Exceptions;


use Core\Models\Langs;

class SysNotFoundException extends SysException
{

    const RESPONSE_STATUS = 404;

    public function __construct($mensaje = null, array $data = null, \Throwable $previous = null )
    {
        if(isset($data)){
            $mensaje = $this->reemplazarTexto($mensaje, $data);
        }
        if(!isset($mensaje))
        {
            $mensaje = Langs::getName(Langs::PERDIDO);
        }
        parent::__construct($mensaje, self::RESPONSE_STATUS, $previous);
    }
}