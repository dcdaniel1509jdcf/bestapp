<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Formularios\Gastos;

class GastosRepGeneralExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */


    protected $dateIni;
    protected $dateFin;
    protected $getGastosVarios;
    protected $getSuministros;
    protected $getMovilizacion;
    protected $getMantenimiento;
    protected $getTramitesEntidades;

    public function __construct($getGastosVarios,$getSuministros,$getMovilizacion,$getMantenimiento,$getTramitesEntidades,$dateIni, $dateFin)
    {
        $this->getGastosVarios = $getGastosVarios;
        $this->getSuministros = $getSuministros;
        $this->getMovilizacion = $getMovilizacion;
        $this->getMantenimiento = $getMantenimiento;
        $this->getTramitesEntidades = $getTramitesEntidades;
        $this->dateFin = $dateFin;
        $this->dateIni = $dateIni;
    }

    public function view(): View
    {

        return view('formularios.descargas.partials.gastosGeneral', [
            'getGastosVarios' => $this->getGastosVarios,
            'getSuministros' => $this->getSuministros,
            'getMovilizacion' => $this->getMovilizacion,
            'getMantenimiento' => $this->getMantenimiento,
            'getTramitesEntidades' => $this->getTramitesEntidades,
            'dateIni'=>$this->dateIni,
            'dateFin'=>$this->dateFin
        ]);
    }
}
