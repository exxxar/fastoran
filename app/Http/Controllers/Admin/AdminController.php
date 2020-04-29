<?php


namespace App\Http\Controllers\Admin;

use Allanvb\LaravelSemysms\Facades\SemySMS;
use App\Enums\DeliveryTypeEnum;
use App\Events\SendSmsEvent;
use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Kitchen;
use App\Parts\Models\Fastoran\MenuCategory;
use App\Parts\Models\Fastoran\RestMenu;
use App\Parts\Models\Fastoran\Restoran;
use App\Parts\Models\Fastoran\Order;
use App\Parts\Models\Fastoran\Rating;
use App\PhonesImport;
use App\RestoranStatisticsSheet;
use App\User;
use App\RestoranInCategory;
use ATehnix\VkClient\Auth;
use ATehnix\VkClient\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DB;
use App\UsersExport;
use App\RestoransStatisticsExport;

class AdminController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kitchen_count = Kitchen::where('is_active', 1)->count();
        $menu_count = RestMenu::all()->count();
        $menu_category_count = MenuCategory::all()->count();
        $restoran_count = Restoran::all()->count();
        $orders_count = array(Order::all()->count(), Order::onlyTrashed()->count());
        $orders_counts = array(
            Order::where('status', 0)->count(),
            Order::where('status', 1)->count(),
            Order::where('status', 2)->count(),
            Order::where('status', 3)->count(),
            Order::where('status', 4)->count()
        );
        $orders_s = Order::where('status',3)->get();
        $orders_sum = $orders_s->sum('summary_price');
        $delivery_range = Order::where('status',3)->sum('delivery_range');
        $delivery_price = Order::where('status',3)->sum('delivery_price');

        $users_count = array(User::all()->count(), User::onlyTrashed()->count());
        $users_counts = array(
            User::where('active', 0)->count(),
            User::where('active', 1)->count(),
        );
        $data = collect([
            'kitchen_count' => $kitchen_count ,
            'orders_count'=>$orders_count,
            'menu_count'=>$menu_count,
            'menu_category_count'=>$menu_category_count,
            'restoran_count'=> $restoran_count,
            'orders_counts'=>$orders_counts,
            'orders_sum'=>$orders_sum,
            'delivery_range' => $delivery_range,
            'delivery_price'=> $delivery_price,
            'users_count'=>$users_count,
            'users_counts'=>$users_counts,
        ]);

        return view('admin.main', compact("data"));

    }
    public function uploadPhones(Request $request)
    {
        $excel_phones = Excel::toArray(new PhonesImport, $request->file);
        $phones = array();
        foreach ($excel_phones[0] as $phone) {
            array_push($phones, $phone[0]);
        }

        return response()
            ->json([
                "message" => "Телефоны успешно загружены",
                'phones' => $phones,
                "status" => 200,
            ]);
    }
    public function preparePhone($phone)
    {
        $vowels = array("(", ")", "-", " ");
        return str_replace($vowels, "", $phone ?? '');
    }
    public function sendMessage(Request $request)
    {
        $phones =array();
        foreach ($request->phones as $phone) {
            $tmp = $this->preparePhone($phone);
            array_push($phones, $tmp);
        }
//        SemySMS::sendMultiple([
//            'to' => $phones,
//            'text' => $request->message,
//            'device_id' => 'active'
//        ]);

//        $messages = SemySMS::multiple();

        foreach ($phones as $phone) {
            event(new SendSmsEvent($phone, $request->message));
//            $messages->addRecipient([
//                'to' => $phone,
//                'text' => $request->message,
//            ]);

        }
//        $messages->send();


        return response()
            ->json([
                "message" => "Сообщения отправлены",
                "status" => 200,
                'phones' => $phones,
            ]);
    }
    public function uploadVk(Request $request)
    {
        $auth = new Auth('7384241', 'eNYSaEk3l2FuZzAePCnH', 'https://fastoran.com/vkontakte', 'market');

        Schema::disableForeignKeyConstraints();
        MenuCategory::truncate();
        RestoranInCategory::truncate();
        Schema::enableForeignKeyConstraints();

        $token = null;

        if ($request->has("code")) {
            $token = $auth->getToken($request->get('code'));

            $api = new Client;
            $api->setDefaultToken($token);

            $response = $api->request('market.getAlbums', [
                'owner_id' => -136275935,
                'count' => 50
            ]);


            RestMenu::truncate();
            //работает
            foreach ($response["response"]["items"] as $item) {
                //echo $item["id"].$item["title"]." ".$item["photo"]["photo_807"]."<br>";

                $response2 = $api->request('market.get', [
                    'owner_id' => -136275935,
                    'album_id' => $item["id"],
                    'count' => 200
                ]);


                foreach ($response2["response"]["items"] as $item2) {
                    //echo $item2["description"]." ".$item2["price"]["text"]." ".$item2["thumb_photo"]." ".$item2["title"]."<br>";


                    //preg_match_all('|\d+|', $item2["description"], $matches);
                    preg_match_all('/(#\w+)/u', $item2["description"], $matches);

                    // $count = $matches[0][0] ?? 0;
                    //dd($matches);


                    $cat = count($matches[0])>0?$matches[0][0]:"#безкатегории";


                    $category = MenuCategory::where("name", $cat)->first();
                    if (is_null($category)) {
                        $category = MenuCategory::create([
                            "name" => $cat
                        ]);
                    }
                    $weight = 0;//count($matches[0])>=2?($matches[0][0] ?? 0):0;

                    //preg_match_all('|\d+|', $item2["price"]["text"], $matches);

                    $price = intval($item2["price"]["text"]);//$matches[0][0] ?? 0;

                    $rest = Restoran::with(["categories"])->where("name", $item["title"])->first();

                    if (is_null($rest))
                        continue;

                    $product = RestMenu::create([
                        'food_name' => $item2["title"],
                        'food_remark' => $item2["description"],
                        'food_ext' => $weight ?? 0,
                        'food_price' => $price,
                        'rest_id' => $rest->id,
                        'food_category_id' => $category->id,
                        'food_img' => $item2["thumb_photo"],
                        'stop_list' => false,
                    ]);


                    if (is_null($rest->categories()->find($category->id)))
                        RestoranInCategory::create([
                            'category_id' => $category->id,
                            'restoran_id' => $rest->id
                        ]);


                    $rate = Rating::create([
                        'content_type' => \App\Enums\ContentTypeEnum::Menu,
                        'content_id' => $product->id,
                    ]);

                    $product->rating_id = $rate->id;
                    $product->save();
                }


                sleep(2);

            }
            //dd($response["items"]);

        }

        return view('admin.main', compact("auth", "token"));
    }
    public function statistics()
    {
        $kitchen_count = Kitchen::where('is_active', 1)->count();
        $menu_count = RestMenu::all()->count();
        $menu_category_count = MenuCategory::all()->count();
        $restoran_count = Restoran::all()->count();
        $orders_count = array(Order::all()->count(), Order::onlyTrashed()->count());
        $orders_counts = array(
            Order::where('status', 0)->count(),
            Order::where('status', 1)->count(),
            Order::where('status', 2)->count(),
            Order::where('status', 3)->count(),
            Order::where('status', 4)->count()
        );
        $orders_s = Order::where('status',3)->get();
        $orders_sum = $orders_s->sum('summary_price');
        $delivery_range = Order::where('status',3)->sum('delivery_range');
        $delivery_price = Order::where('status',3)->sum('delivery_price');


        $users_count = array(User::all()->count(), User::onlyTrashed()->count());
        $users_counts = array(
            User::where('active', 0)->count(),
            User::where('active', 1)->count(),

        );
        $data = collect([
            'kitchen_count' => $kitchen_count ,
            'orders_count'=>$orders_count,
            'menu_count'=>$menu_count,
            'menu_category_count'=>$menu_category_count,
            'restoran_count'=> $restoran_count,
            'orders_counts'=>$orders_counts,
            'orders_sum'=>$orders_sum,
            'delivery_range' => $delivery_range,
            'delivery_price'=> $delivery_price,
            'users_count'=>$users_count,
            'users_counts'=>$users_counts,
        ]);
        return view('admin.statistics', compact("data"));

    }
    public function getStatistics()
    {
        $all_deliverymans = User::where('user_type', 1)->get();
        $deliverymans = array();
        foreach ($all_deliverymans as $deliveryman){
            $deliveryman->orders_count = Order::where('deliveryman_id',$deliveryman->id)->where('status',3)->count();
            if( $deliveryman->orders_count != 0 ) {
                $deliveryman->delivery_range = Order::where('deliveryman_id', $deliveryman->id)->where('status', 3)->sum('delivery_range');
                $deliveryman->delivery_price = Order::where('deliveryman_id', $deliveryman->id)->where('status', 3)->sum('delivery_price');
                $orders = Order::where('deliveryman_id', $deliveryman->id)->where('status', 3)->get();
                $deliveryman->summary_price = $orders->sum('summary_price');
                array_push($deliverymans, $deliveryman);
            }
        }
        $active_users = User::where('user_type', 0)->get();
        $users = array();
        foreach ($active_users as $user){

            $user->orders_count = Order::where('user_id',$user->id)->where('status',3)->count();
            if( $user->orders_count != 0 )
            {
                $orders = Order::where('user_id',$user->id)->where('status',3)->get();
                $user->summary_price = $orders->sum('summary_price');
                array_push($users, $user);
            }
        }

//        DB::statement(DB::raw("SET lc_time_names = 'ru_UA';"));
//        $months = DB::table('orders')->select(DB::raw("(COUNT(*)) as y"),DB::raw("MONTHNAME(created_at) as name"))
//        ->whereYear('created_at', date('Y'))
//        ->groupBy('name')
//        ->get();
//
//        foreach ($months as $month)
//        {
//         $month->drilldown=$month->name;
//        }
//
//        $days = DB::table('orders')->select(DB::raw("(COUNT(*)) as y"),DB::raw("MONTHNAME(created_at) as month"),DB::raw("DAY(created_at) as name"))
//            ->groupBy('month', 'name')
//            ->whereYear('created_at', date('Y'))
//            ->get();
//        $test = $days->groupBy('month');
//        $result = array();
//        foreach ($test as $key => $value)
//        {
//            $object = (object)[];
//            $object->name = $key;
//            $object->id = $key;
//            $object->data = array();
//
//            foreach ($value as $item) {
////              $tmp = array($item->day, $item->y);
//                array_push($object->data, $item);
//            }
//            array_push($result, $object);
//        }

        $startDate = Carbon::today()->startOfYear()->subYears(2);
        $endDate = Carbon::today()->endOfYear();
        $orders_statistics = $this->getOrdersByDate($startDate, $endDate);

        return response()
            ->json([
                "message" => "Статистика успешно загружена",
                'users' => $users,
                'deliverymans' => $deliverymans,
                'series' => $orders_statistics->original['series'],
                'drilldown' => $orders_statistics->original['drilldown'],
                "status" => 200,
            ]);
    }
    public function getOrdersByDate($startDate, $endDate)
    {
        $orders = Order::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])->where('status', 3)->get();
        foreach ($orders as $order)
        {
            $order->year = $order->created_at->year;
            $order->month = $order->created_at->locale('ru')->monthName.', '.$order->year;
            $order->day = $order->created_at->day;
        }
        $tmp_years = $orders->sortBy('created_at')->groupBy('year');
        $series = array();
        $drilldown = array();
        foreach ($tmp_years as $year => $year_orders)
        {
            //series (year)
            $series_year = (object)[];
            $series_year->name = $year;
            $series_year->drilldown = $year;
            $count = $year_orders->count();
            $series_year->y = $count;
            array_push($series, $series_year);

            //drilldown (year)
            $drilldown_year = (object)[];
            $drilldown_year->name = $year;
            $drilldown_year->id = $year;
            $drilldown_year->data = array();
            array_push($drilldown, $drilldown_year);

            $tmp_months = $year_orders->groupBy('month');
            foreach ($tmp_months as $month_name => $month_orders) {
                //year_data_month // drilldown (year.data)
                $series_month = (object)[];
                $series_month->name = $month_name;
                $series_month->drilldown = $month_name;
                $count = $month_orders->count();
                $series_month->y = $count;
                array_push($drilldown_year->data, $series_month);

                $drilldown_month = (object)[];
                $drilldown_month->name = $month_name;
                $drilldown_month->id = $month_name;
                $drilldown_month->data = array();

                array_push($drilldown, $drilldown_month);
                $tmp_days = $month_orders->groupBy('day');
                foreach ($tmp_days as $day => $day_orders) {
                    //month_data_day // drilldown (month.data)
                    $series_day = (object)[];
                    $series_day->name = $day;
                    $count = $day_orders->count();
                    $series_day->y = $count;
                    array_push($drilldown_month->data, $series_day);
                }
            }
        }

        return response()
            ->json([
                "message" => "Статистика за определенный период успешно загружена",
                'series' => $series,
                'drilldown' => $drilldown,
                "status" => 200,
                'date' => $startDate,
            ]);

    }
    public function downloadStatistics() {
        return Excel::download(new UsersExport, 'statistics.xlsx');
    }
    public function getRestoransStatistics($startDate, $endDate) {
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
        return Excel::download(new RestoransStatisticsExport($statistics), 'report.xlsx');
    }
}
