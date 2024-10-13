<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Formularios\Gastos;

class GastosRepBestPCExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */


    protected $gastosBestPC;
    protected $dateIni;
    protected $dateFin;

    public function __construct($gastosBestPC,$dateIni, $dateFin)
    {
        $this->gastosBestPC = $gastosBestPC;
        $this->dateFin = $dateFin;
        $this->dateIni = $dateIni;
    }

    public function view(): View
    {

        return view('formularios.descargas.partials.reposicionBestPC', [
            'gastosBestPC' => $this->gastosBestPC,
            'dateIni'=>$this->dateIni,'dateFin'=>$this->dateFin
        ]);
    }
}
