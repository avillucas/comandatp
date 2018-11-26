<?php
namespace Core\Exceptions;


class SysException extends \Exception
{

    const VALIDATION = 100;
    const NOT_FOUND  = 404;
    const FULL_EVENT = 401;
    const UNTRUST    = 402;
    const FORBIDEN   = 403;
    const FATAL = 500;

    /**
     * SysException constructor.
     */
    public function __construct($message,$responseStatus =500,  \Throwable $previous = null)
    {
        parent::__construct($message,$responseStatus ,$previous);
        $this->responseStatus = $responseStatus;
    }

    /**
     * @return int
     */
    public function getResponseStatus()
    {
        return $this->responseStatus;
    }


    protected function reemplazarTexto($mensaje,$data=null)
    {
        if($data){
            foreach ($data as $key => $val)
            {
                $mensaje = str_replace(':'.$key,$val,$mensaje);
            }
        }
        return $mensaje;
    }

}