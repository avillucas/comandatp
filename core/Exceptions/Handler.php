<?php
/**
 * Created by PhpStorm.
 * User: Lucas-notebook
 * Date: 4/11/2018
 * Time: 7:53 PM
 */

namespace Core\Exceptions;


class Handler
{
    public function __invoke($request, $response, $exception)
    {
        if($exception instanceof SysException){
            return $response->withJson($exception->getMessage(),$exception->getResponseStatus());
        }
        return $response->withJson($exception->getMessage(),500);
    }
}