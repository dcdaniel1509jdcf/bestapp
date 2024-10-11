<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Formularios\Gastos;

class GastosExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $gastosHarwest;
    protected $gastosBestPC;
    protected $dateIni;
    protected $dateFin;

    public function __construct($gastosHarwest,$gastosBestPC,$dateIni, $dateFin)
    {
        $this->gastosHarwest = $gastosHarwest;
        $this->gastosBestPC = $gastosBestPC;
        $this->dateFin = $dateFin;
        $this->dateIni = $dateIni;
    }

    public function view(): View
    {

        return view('formularios.descargas.partials.gastos', [
            'gastosHarwest' => $this->gastosHarwest,
            'gastosBestPC' => $this->gastosBestPC,
            'dateIni'=>$this->dateIni,'dateFin'=>$this->dateFin
        ]);
    }
}
