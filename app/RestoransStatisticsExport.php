<?php

namespace App;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class RestoransStatisticsExport implements WithMultipleSheets
{
    use Exportable;
    protected $statistics;

    public function __construct(array $statistics)
    {
        $this->statistics = $statistics;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->statistics as $restoran) {
            $sheet = new RestoranStatisticsSheet($restoran);
//            $sheet->setCellValue('G1', 'Test String');
//            $sheet->setCellValue('H1', '$restoran->order_count');

//            $sheet->cell('G1', function($cell) {
//                $cell->setValue('order_count');
//            });
//            $sheet->cell('H1', function($cell, $restoran) {
//                $cell->setValue($restoran->order_count);
//            });
            array_push($sheets, $sheet);

        }
        return $sheets;
    }
}
