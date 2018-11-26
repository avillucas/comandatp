<?php
namespace Core\Api;


use Core\Dao\RegistroAccesoDao;
use Slim\Http\Request;
use Slim\Http\Response;

class ReportesEmpleadosApi extends ReportesApi
{

    public function accesos(Request $request, Response $response)
    {
        $this->traerFechasBusqueda($request);

        $todos = RegistroAccesoDao::reporteEmpleado($this->getReporteInicio(),$this->getReporteFin());
        return $response->withJson($todos, 200);
    }

}