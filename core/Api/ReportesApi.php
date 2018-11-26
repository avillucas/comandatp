<?php
namespace Core\Api;


use Core\Exceptions\SysValidationException;
use Slim\Http\Request;

abstract class ReportesApi
{
    /** @var \DateTime $reporteInicio */
    private $reporteInicio = null;

    /** @var \DateTime $reporteFin */
    private $reporteFin = null;


    protected function traerFechasBusqueda(Request $request)
    {
        if(!empty($request->getParam('desde')) && !empty($request->getParam('hasta')))
        {
            $desde  = new \DateTime($request->getParam('desde'));
            $hasta  = new \DateTime($request->getParam('hasta'));
            //TODO validar que desde sea menor a hasta
            if($desde >= $hasta){
                throw  new SysValidationException("Las fechas desde debe ser menor al hasta ");
            }
            $this->setReporteFin($hasta);
            $this->setReporteInicio($desde);
        }
    }

    public function solicitaRango()
    {
        return boolval($this->getReporteFin() != null && $this->getReporteInicio() != null);
    }

    /**
     * @return \DateTime
     */
    public function getReporteInicio()
    {
        return $this->reporteInicio;
    }

    /**
     * @param \DateTime $reporteInicio
     */
    protected function setReporteInicio($reporteInicio)
    {
        $this->reporteInicio = $reporteInicio;
    }

    /**
     * @return \DateTime
     */
    public function getReporteFin()
    {
        return $this->reporteFin;
    }

    /**
     * @param \DateTime $reporteFin
     */
    protected function setReporteFin($reporteFin)
    {
        $this->reporteFin = $reporteFin;
    }


}