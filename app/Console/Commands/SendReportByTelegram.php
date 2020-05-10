<?php

namespace App\Console\Commands;

use App\Parts\Models\Fastoran\Order;
use App\Parts\Models\Fastoran\Restoran;
use App\PaymentReportExport;
use App\RestoransStatisticsExport;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendReportByTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:sendReport {period}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send payment report by telegram every day, week or month';

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
        $report_name = 'payment_report.xlsx';
        if( $this->argument('period') == 'today')
        {
            $startDate = Carbon::today()->format('Y-m-d');
            $endDate = Carbon::today()->format('Y-m-d');
            $report_name = 'day_payment_report'.$startDate.'.xlsx';
        }
        if ( $this->argument('period') == 'week')
        {
            $startDate = Carbon::today()->startOfWeek()->format('Y-m-d');
            $endDate = Carbon::today()->endOfWeek()->format('Y-m-d');
            $report_name = 'week_payment_report'.$startDate.'_'.$endDate.'.xlsx';
        }
        if ( $this->argument('period') == 'month')
        {
            $startDate = Carbon::today()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::today()->endOfMonth()->format('Y-m-d');
            $report_name = 'month_payment_report'.$startDate.'_'.$endDate.'.xlsx';
        }
        $restorans = Restoran::all();

        $report = (object)[];
        $report->total_payment_delivery_price = 0;
        $report->total_payment_summary_price = 0;

        $restorans_records = array();
        $result = array();
        foreach ($restorans as $restoran) {
            $r = (object)[];
            $r->name = $restoran->name;
            $r->orders_count = Order::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
                ->where('rest_id',$restoran->id)
                ->where('status',3)
                ->count();
            $r->delivery_price = Order::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
                ->where('rest_id',$restoran->id)
                ->where('status', 3)
                ->sum('delivery_price');
            $r->payment_delivery_price = $r->delivery_price * 0.6;
            $report->total_payment_delivery_price += $r->payment_delivery_price;
            $orders = Order::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
                ->where('rest_id',$restoran->id)
                ->where('status', 3)
                ->get();
            $r->summary_price = $orders->sum('summary_price');
            $r->payment_summary_price = $r->summary_price * 0.15;
            if($restoran->name =='ДонМак' || $restoran->name =='Пиццерия "Большой Джон"')
            {
                $r->payment_summary_price = $r->summary_price * 0.075;
            }
            $report->total_payment_summary_price += $r->payment_summary_price;
            array_push($restorans_records, $r);
        }
        $report->person_payment_delivery_price = $report->total_payment_delivery_price/4;
        $report->person_payment_summary_price = $report->total_payment_summary_price/4;
        $report->restorans = $restorans_records;
        array_push($result, $report);
        Excel::store(new PaymentReportExport($result),  $report_name, 'public');
        $url = Storage::url($report_name);
        Telegram::sendDocument([
            'chat_id' => env("TELEGRAM_FASTORAN_ADMIN_CHANNEL"),
            'document' =>$url,
        ]);
    }
}
