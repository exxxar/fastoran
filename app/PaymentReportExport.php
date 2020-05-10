<?php

namespace App;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PaymentReportExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $report;

    public function __construct(array $report)
    {
        $this->report = $report;
    }

    public function array(): array
    {
        $e = (object)[];
        $e->empty_line = '';
        array_push($this->report[0]->restorans, $e);

        $t = (object)[];
        $t->delivery_price = 'Итого сумма от доставки';
        $t->payment_delivery_price = 'Итого сумма от доставки на человека';
        $t->summary_price = 'Итого сумма от заказов';
        $t->payment_summary_price = 'Итого сумма от заказов на человека';
        array_push($this->report[0]->restorans, $t);

        $r = (object)[];
        $r->delivery_price = $this->report[0]->total_payment_delivery_price;
        $r->payment_delivery_price = $this->report[0]->person_payment_delivery_price;
        $r->summary_price = $this->report[0]->total_payment_summary_price;
        $r->payment_summary_price = $this->report[0]->person_payment_summary_price;
        array_push($this->report[0]->restorans, $r);
        return $this->report[0]->restorans;
    }

    public function headings(): array
    {
        return
            [
                'Ресторан',
                'Кол-во заказов',
                'Общая сумма доставки',
                'Сумма от доставки',
                'Общая сумма заказов',
                'Сумма от заказов'
            ];
    }
}
