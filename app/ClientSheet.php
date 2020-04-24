<?php

namespace App;

use App\User;
use App\Parts\Models\Fastoran\Order;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ClientSheet implements FromArray, WithTitle, WithColumnFormatting,  WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        $active_users = User::where('user_type', 0)->get();
        $users = array();
        foreach ($active_users as $user){

            $user->orders_count = Order::where('user_id',$user->id)->where('status',3)->count();
            if( $user->orders_count != 0 )
            {
                $u = (object)[];
                $u->id = $user->id;
                $u->name = $user->name;
                $u->phone = $user->phone;
                $u->orders_count = $user->orders_count;
                $orders = Order::where('user_id',$user->id)->where('status',3)->get();
                $user->summary_price = $orders->sum('summary_price');
                $u->summary_price = $user->summary_price;
                array_push($users, $u);
            }
        }
        return $users;
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
            'Кол-во заказов',
            'Сумма заказов'
        ];
    }
    /**
    * @return string
    */
    public function title(): string
    {
    return 'Клиенты';
    }
}
