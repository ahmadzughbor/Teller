<?php

namespace App\Exports;

use App\Models\processes;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\FromCollection;

class processessExport implements FromView
{


    protected $data;

    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return processes::all();
    // }
    public function view(): View
    {
        return view('admin.exports.processessExport', [
            'data' => $this->data
        ]);
    }
}
