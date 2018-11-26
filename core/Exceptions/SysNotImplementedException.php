<?php
namespace Core\Exceptions;

class SysNotImplementedException extends SysException
{

    const RESPONSE_STATUS = 500;

    public function __construct( )
    {
        parent::__construct("Aun no implementado", self::RESPONSE_STATUS);
    }
}