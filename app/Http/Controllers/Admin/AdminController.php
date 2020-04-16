<?php


namespace App\Http\Controllers\Admin;

use Allanvb\LaravelSemysms\Facades\SemySMS;
use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Kitchen;
use App\Parts\Models\Fastoran\MenuCategory;
use App\Parts\Models\Fastoran\RestMenu;
use App\Parts\Models\Fastoran\Restoran;
use App\Parts\Models\Fastoran\Order;
use App\Parts\Models\Fastoran\Rating;
use App\PhonesImport;
use App\User;
use App\RestoranInCategory;
use ATehnix\VkClient\Auth;
use ATehnix\VkClient\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

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
//        $data->push($kitchen_count);
//        $data->push($orders_counts);
//        $order_count1 = Order::where('status', 0)->count();
//        $order_count2 = Order::where('status', 1)->count();
//        $order_count3 = Order::where('status', 2)->count();
//        $order_count4 = Order::where('status', 3)->count();
//        $order_count5 = Order::where('status', 4)->count();

//        $kitchen_count = $kitchens->count();
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
    public function sendMessage(Request $request)
    {
        SemySMS::sendMultiple([
            'to' => $request->phones,
            'text' => "$request->message"
        ]);
//        'to' => ['+1234567890','+1567890234','+1902345678'],
//        SemySMS::sendOne([
//            'to' => $user->phone,
//            'text' => "$request->message"
//        ]);
        return response()
            ->json([
                "message" => "Сообщения отправлены",
                "status" => 200,
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
}
