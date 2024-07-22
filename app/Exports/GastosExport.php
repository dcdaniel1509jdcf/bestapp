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
    protected $dateIni;
    protected $dateFin;

    public function __construct($dateIni, $dateFin)
    {
        $this->dateIni = $dateIni;
        $this->dateFin = $dateFin;
    }


    public function view(): View
    {
        return view('formularios.descargas.partials.gastos', [
            'gastos' => Gastos::whereBetween('fecha', [$this->dateIni, $this->dateFin])->get()
        ]);
    }
}
