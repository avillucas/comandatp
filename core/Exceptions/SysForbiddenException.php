<?php
namespace Core\Exceptions;

use Core\Models\Langs;

class SysForbiddenException extends SysException
{

    const RESPONSE_STATUS = 403;

    public function __construct($mensaje = null, array $data = [] )
    {
        $status = SysException::FORBIDEN;
        if(isset($data)){
            $mensaje = $this->reemplazarTexto($mensaje, $data);
        }
        if(!isset($mensaje))
        {
            $mensaje = Langs::getName(Langs::ACCESO_DENEGADO);
        }
        parent::__construct($mensaje, $status,self::RESPONSE_STATUS);
    }
}