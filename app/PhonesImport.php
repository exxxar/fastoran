<?php
namespace App;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PhonesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        return $rows;
    }
}
