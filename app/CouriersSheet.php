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

class CouriersSheet implements FromArray, WithTitle, WithColumnFormatting,  WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        $all_deliverymans = User::where('user_type', 1)->get();
        $deliverymans = array();
        foreach ($all_deliverymans as $deliveryman){
            $orders_count = Order::where('deliveryman_id',$deliveryman->id)->where('status',3)->count();
            if( $orders_count != 0 ) {
                $d = (object)[];
                $d->id = $deliveryman->id;
                $d->name = $deliveryman->name;
                $d->phone = $deliveryman->phone;
                $d->deliveryman_type= DeliveryTypeEnum::getKey($deliveryman->deliveryman_type);
                $d->orders_count = $orders_count;
                $d->delivery_range = Order::where('deliveryman_id', $deliveryman->id)->where('status', 3)->sum('delivery_range');
                $d->delivery_price = Order::where('deliveryman_id', $deliveryman->id)->where('status', 3)->sum('delivery_price');
                $orders = Order::where('deliveryman_id', $deliveryman->id)->where('status', 3)->get();
                $d->summary_price = $orders->sum('summary_price');
                array_push($deliverymans, $d);
            }
        }
        return $deliverymans;
    }
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    public function headings(): array
    {
        return [
            "id",
            'Имя' ,
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
    return 'Курьеры';
    }
}
