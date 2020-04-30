<?php

namespace App\Console\Commands;

use App\Enums\DeliveryTypeEnum;
use App\Mail\ReportMail;
use App\Parts\Models\Fastoran\Order;
use App\Parts\Models\Fastoran\Restoran;
use App\RestoransStatisticsExport;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class SendReportByMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:sendReport {period}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send statistics by mail everyday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $report_name = 'report.xlsx';
        if( $this->argument('period') =='today')
        {
            $startDate = Carbon::today()->format('Y-m-d');
            $endDate = Carbon::today()->format('Y-m-d');
            $report_name = 'day_report'.$startDate.'.xlsx';
        }
        if ( $this->argument('period') =='week')
        {
            $startDate = Carbon::today()->startOfWeek()->format('Y-m-d');
            $endDate = Carbon::today()->endOfWeek()->format('Y-m-d');
            $report_name = 'week_report'.$startDate.'_'.$endDate.'.xlsx';
        }
        $restorans = Restoran::all();
        $all_deliverymans = User::where('user_type', 1)->get();
        $statistics = array();
        foreach ($restorans as $restoran) {
            $deliverymans = array();
            foreach ($all_deliverymans as $deliveryman){
                $orders_count = Order::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
                    ->where('rest_id',$restoran->id)
                    ->where('deliveryman_id',$deliveryman->id)
                    ->where('status',3)
                    ->count();
                if( $orders_count != 0 ) {
                    $d = (object)[];
                    $d->id = $deliveryman->id;
                    $d->name = $deliveryman->name;
                    $d->phone = $deliveryman->phone;
                    $d->deliveryman_type= DeliveryTypeEnum::getKey($deliveryman->deliveryman_type);
                    $d->orders_count = $orders_count;
                    $d->delivery_range = Order::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
                        ->where('rest_id',$restoran->id)
                        ->where('deliveryman_id', $deliveryman->id)
                        ->where('status', 3)
                        ->sum('delivery_range');
                    $d->delivery_price = Order::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
                        ->where('rest_id',$restoran->id)
                        ->where('deliveryman_id', $deliveryman->id)
                        ->where('status', 3)
                        ->sum('delivery_price');
                    $orders = Order::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
                        ->where('rest_id',$restoran->id)
                        ->where('deliveryman_id', $deliveryman->id)
                        ->where('status', 3)
                        ->get();
                    $d->summary_price = $orders->sum('summary_price');
                    array_push($deliverymans, $d);
                }
            }
            $r = (object)[];
            $r->name = $restoran->name;
            $r->orders_count = Order::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
                ->where('rest_id',$restoran->id)
                ->where('status',3)
                ->count();
            $r->delivery_range = Order::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
                ->where('rest_id',$restoran->id)
                ->where('status', 3)
                ->sum('delivery_range');
            $r->delivery_price = Order::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
                ->where('rest_id',$restoran->id)
                ->where('status', 3)
                ->sum('delivery_price');
            $orders = Order::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
                ->where('rest_id',$restoran->id)
                ->where('status', 3)
                ->get();
            $r->summary_price = $orders->sum('summary_price');
            $r->couriers = $deliverymans;
            array_push($statistics, $r);
        }
        Excel::store(new RestoransStatisticsExport($statistics), $report_name);
        $filename = storage_path() .'/app/'.$report_name;
        Mail::to(env('ADMIN_MAIL'))->send(new ReportMail($filename));
    }
}
