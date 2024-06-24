<?php

namespace App\Exports;

use App\Models\Formularios\Depositos;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class DepositosExport implements FromView
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
        return view('formularios.descargas.partials.depositos', [
            'depositos' => Depositos::whereBetween('fecha', [$this->dateIni, $this->dateFin])->get()
        ]);
    }
}
