<?php


namespace App;

use App\Enums\DeliveryTypeEnum;
use App\User;
use App\Parts\Models\Fastoran\Order;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RestoranStatisticsSheet implements FromArray, WithTitle, WithColumnFormatting, WithHeadings, ShouldAutoSize
{
    private $restoran;

    public function __construct(object $restoran)
    {
        $this->restoran = $restoran;
    }
    public function array(): array
    {
        $e = (object)[];
        $e->empty_line = '';
        array_push($this->restoran->couriers, $e);

        $t = (object)[];
        $t->orders_count = 'Итого кол-во заказов';
        $t->delivery_range = 'Итого километраж';
        $t->delivery_price = 'Итого сумма доставки';
        $t->summary_price = 'Итого сумма заказов';
        array_push($this->restoran->couriers, $t);

        $r = (object)[];
        $r->orders_count = $this->restoran->orders_count;
        $r->delivery_range = $this->restoran->delivery_range;
        $r->delivery_price = $this->restoran->delivery_price;
        $r->summary_price = $this->restoran->summary_price;
        array_push($this->restoran->couriers, $r);

        return $this->restoran->couriers;
    }

//    public function map($row): array
//    {
//        return [
//            [
//                $this->restoran->orders_count
//            ],
//            [
//                $row->id,
//                $row->name,
//                $row->phone,
//                $row->deliveryman_type,
//                $row->orders_count,
//                $row->delivery_range,
//                $row->delivery_price,
//                $row->summary_price
//            ]
//        ];
//    }
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function headings(): array
    {
        return
            [
            "id",
            'Имя',
            'Телефон',
            'Тип курьера',
            'Кол-во заказов',
            'Общий километраж',
            'Общая сумма доставки',
            'Сумма заказов'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->restoran->name;
    }
}
