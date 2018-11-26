<?php
namespace Core\Middleware;

use Core\Compra;
use Slim\Http\Request;
use Slim\Http\Response;

class MWRutas
{

	public function agregarUrlImagenDeCompra(Request $request, Response $response, $next)
    {
        /** @var Response $responsenueva */
        $responsenueva =  $next($request, $response);
        $streamBody = $responsenueva->getBody();
        $streamBody->rewind();
        $compras =json_decode( $streamBody->getContents(),true);
        $directorioImagenesCompra = $request->getUri()->getScheme().'://'.$request->getUri()->getHost().':'.$request->getUri()->getPort().'/'.Compra::IMAGEN_DIRECTORIO.'/';
        /** @var Compra $compra */
        foreach ($compras as &$compra)
        {
            $compra['imagen'] = $directorioImagenesCompra.$compra['imagen'] ;
        }
        return $responsenueva->withJson($compras);

    }

}
