<?php

namespace App\Imports;

use App\Models\MasterNumbers;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;

class NumbersImport implements ToCollection
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {

    }
}
