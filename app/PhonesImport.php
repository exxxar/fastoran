<?php
namespace App;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PhonesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        //return $rows;
//        $array =array();
//        foreach ($rows as $row)
//        {
//            $row->save();
//            array_push($array, $row[0]);
////            return $rows;

//        }
//        return $array;
    }
}
