<?php

namespace App\Http\Controllers\Admin;

use Allanvb\LaravelSemysms\Facades\SemySMS;
use App\Classes\Utilits;
use App\Enums\DeliveryTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Parts\Models\Fastoran\Order;

use App\Parts\Models\Fastoran\OrderDetail;
use App\Parts\Models\Fastoran\RestMenu;
use App\Parts\Models\Fastoran\Restoran;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Laravel\Facades\Telegram;
use Yandex\Geocode\Facades\YandexGeocodeFacade;


class OrderController extends Controller
{
    use Utilits;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    public function checkValidCode(Request $request)
    {
        $phone = $request->get("phone") ?? '';
        $code = $request->get("code") ?? '';

        $vowels = array("(", ")", "-", " ");
        $phone = str_replace($vowels, "", $phone);

        $user = User::where("phone", $phone)->first();

        if (is_null($user))
            return response()
                ->json([
                    "message" => "Номер телефона не найден!",
                    "is_valid" => false,
                ]);

        if ($user->auth_code != $code)
            return response()
                ->json([
                    "message" => "Вам на телефон отправлен СМС код подветрждения!",
                    "is_valid" => false,
                ]);

        return response()
            ->json([
                "message" => "Номер успешно подтвержден!",
                "is_valid" => true,
            ]);


    }

    public function resendSmsVerify(Request $request)
    {
        $phone = $request->get("phone") ?? '';

        $vowels = array("(", ")", "-", " ");
        $phone = str_replace($vowels, "", $phone);


        $user = User::where("phone", $phone)->first();
        if (!is_null($user)) {
            SemySMS::sendOne([
                'to' => $user->phone,
                'text' => "Ваш пароль для доступа к ресурсу https://fastoran.com: " . $user->auth_code
            ]);
            return response()
                ->json([
                    "message" => "СМС успешно отправлено",
                ]);
        }

        return response()
            ->json([
                "message" => "Ошибка отправки СМС",
            ]);

    }

    public function sendSmsVerify(Request $request)
    {

        $phone = $request->get("phone") ?? '';
        $name = $request->get("name") ?? '';

        $vowels = array("(", ")", "-", " ");
        $phone = str_replace($vowels, "", $phone);


        $user = User::where("phone", $phone)->first();

        $client = new Client();

        if (is_null($user))
            $resp = $client->request('POST', 'https://fastoran.com/api/v1/auth/signup_phone', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Requested-With' => 'XMLHttpRequest',
                ],
                'body' => json_encode([
                    'phone' => $phone,
                    'name' => $name
                ]),
            ]);
        else
            $resp = $client->request('POST', 'https://fastoran.com/api/v1/auth/sms', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Requested-With' => 'XMLHttpRequest',
                ],
                'body' => json_encode([
                    'phone' => $phone,
                ]),
            ]);

        if (!is_null($user))
            return response()
                ->json([
                    "message" => $user->auth_code != null ? "Введите предидущий код из СМС!" : "На ваш номер отправлен СМС с кодом!"
                ], 200);
        else
            return response()
                ->json([
                    "message" => "На ваш номер отправлен СМС с кодом!"
                ], 200);


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $phone = $request->get("phone") ?? null;
        $vowels = array("(", ")", "-", " ");
        $phone = str_replace($vowels, "", $phone ?? '');


        $userId = (User::where("phone", $phone)->first())->id ?? null;

        Log::info("ORDER STORE:$userId $phone");

        $user = User::find(!is_null($userId) ? $userId : auth()->guard('api')->user()->id);

        $order = Order::create($request->all());

        $data = YandexGeocodeFacade::setQuery($request->get("receiver_address") ?? '')->load();

        $data = $data->getResponse();

        if (!is_null($data)) {
            $lat = $data->getLatitude();
            $lon = $data->getLongitude();

            $order->latitude = $lat;
            $order->longitude = $lon;
            $order->save();
        }

        $order->user_id = $user->id;
        //$order->latitude = $request->get("receiver_latitude") ?? null;
        //$order->longitude = $request->get("receiver_longitude") ?? null;
        $order->save();

        if (is_null($user->name) || empty($user->name)) {
            $user->name = $order->receiver_name;
            $user->save();
        }


        // return json_decode($request->get("order_details"),true);
        $order_details = $request->get("order_details");

        $delivery_order_tmp = "";
        foreach ($order_details as $od) {
            $detail = OrderDetail::create($od);
            $detail->order_id = $order->id;
            $detail->save();

            $product = RestMenu::find($detail->product_id);
            $local_tmp = sprintf("#%s %s (%s) %s шт. %s руб.\n",
                $detail->product_id,
                $product->food_name,
                $detail->more_info ?? '-',
                $detail->count,
                $product->food_price
            );

            $delivery_order_tmp .= $local_tmp;
        }

        $rest = Restoran::find($order->rest_id);

        if (is_null($rest->latitude) || is_null($rest->longitude)) {

            $data = YandexGeocodeFacade::setQuery($rest->adress ?? '')->load();

            $data = $data->getResponse();

            if (!is_null($data)) {
                $lat = $data->getLatitude();
                $lon = $data->getLongitude();

                $rest->latitude = $lat;
                $rest->longitude = $lon;
                $rest->save();
            }

        }

        $channel = $rest->telegram_channel;
        $range = ($this->calculateTheDistance($order->latitude ?? 0, $order->longitude ?? 0, $rest->latitude ?? 0, $rest->longitude ?? 0) / 1000);

        $range1 = $range;
        $range2 = $range + 2;

        $price1 = ceil(env("BASE_DELIVERY_PRICE") + ($range1 * env("BASE_DELIVERY_PRICE_PER_KM")));
        $price2 = ceil(env("BASE_DELIVERY_PRICE") + ($range2 * env("BASE_DELIVERY_PRICE_PER_KM")));

        $deliver_price = ceil(env("BASE_DELIVERY_PRICE") + ($range2 * env("BASE_DELIVERY_PRICE_PER_KM")));


        $message = sprintf("*Заявка #%s*\nРесторан:_%s_\nФ.И.О.:_%s_\nТелефон:_%s_\nЗаказ:\n%s\nЗаметка к заказу:%s\nАдрес доставки:%s\nЦена доставки:*%sруб.-%s руб.*(Дистанция:%.2fкм-%.2fкм)\nЦена заказа:*%s руб.*",
            $order->id,
            $rest->name,
            $order->receiver_name ?? $user->name,
            $order->receiver_phone ?? $user->phone,
            $delivery_order_tmp,
            $order->receiver_order_note ?? "Не указана",
            $order->receiver_address ?? "Не задан",
            $price1,
            $price2,
            $range1,
            $range2,
            $order->summary_price
        );

        $order->delivery_price = $price2;
        $order->delivery_range = floatval(sprintf("%.2f", $range2));

        $order->save();


        $tmp = "" . $order->id;
        while (strlen($tmp) < 10)
            $tmp = "0" . $tmp;

        $this->sendToTelegram($channel, $message, [
            [
                ["text" => "Подтвердить заказ!", "url" => "https://t.me/delivery_service_dn_bot?start=001$tmp"],
                ["text" => "Отменить заказ!", "url" => "https://t.me/delivery_service_dn_bot?start=002$tmp"]
            ]
        ]);


        return response()
            ->json([
                "message" => "success",
                "data" => $request->all(),
                "status" => 200
            ]);
    }

    public function getOrderHistory()
    {
        $user = User::find(auth()->guard('api')->user()->id ?? 0);

        if (is_null($user))
            return response()
                ->json([
                    "message" => "User not found",
                    "orders" => [],
                    "status" => 404
                ]);

        $orders = Order::with(["details", "restoran", "details.product"])
            ->where("user_id", $user->id)
            ->get();


        return response()
            ->json([
                "message" => "success",
                "orders" => $orders,
                "status" => 200
            ]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Order $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        $order_details = OrderDetail::where('order_id', $id)->delete();
        return response()
            ->json([
                'status' => 200,
                "message" => "Заказ успешно удален"
            ]);
    }

    public function acceptOrder(Request $request, $orderId)
    {

        $order = Order::with(["restoran"])
            ->where("id", $orderId)
            ->first();

        $user = User::find($request->user()->id);

        if (is_null($user))
            return response()
                ->json([
                    "message" => "Deliveryman not found!"
                ], 200);

        if ($user->user_type !== UserTypeEnum::Deliveryman)
            return response()
                ->json([
                    "message" => "You are not deliveryman"
                ], 200);

        if (is_null($order))
            return response()
                ->json([
                    "message" => "Order not found!"
                ], 404);

        //todo:проверить работу
        if (!is_null($order->deliveryman_id))
            return response()
                ->json([
                    "message" => "Order was already taken!"
                ], 200);

        $order->deliveryman_id = $user->id;
        $order->save();

        $message = sprintf("Заказ *#%s* (%s) взят доставщиком *#%s (%s)*",
            $order->id,
            $order->receiver_phone,
            $user->id,
            $user->phone ?? "Без номера"
        );

        $this->sendToTelegram($order->restoran->telegram_channel, $message);

        return response()
            ->json([
                "message" => "Success"
            ], 200);
    }

    public function declineOrder(Request $request, $orderId)
    {
        $order = Order::with(["restoran"])
            ->where("id", $orderId)
            ->first();

        $user = User::find($request->user()->id);

        if (is_null($user))
            return response()
                ->json([
                    "message" => "Deliveryman not found!"
                ], 200);

        if ($user->user_type !== UserTypeEnum::Deliveryman)
            return response()
                ->json([
                    "message" => "You are not deliveryman"
                ], 200);

        if (is_null($order))
            return response()
                ->json([
                    "message" => "Order not found!"
                ], 404);

        if ($order->deliveryman_id !== $user->id)
            return response()
                ->json([
                    "message" => "Order linked with another Deliveryman!"
                ], 200);

        $order->deliveryman_id = null;
        $order->save();

        $message = sprintf("Доставщик *#%s* отказался от заказа *#%s*",
            $user->id,
            $order->id
        );

        $this->sendToTelegram($order->restoran->telegram_channel, $message);

        return response()
            ->json([
                "message" => "Success"
            ], 200);
    }

    public function declineOrderAdmin(Request $request, $orderId)
    {
        $comment = $request->get("comment") ?? "Позиция отсутствует";

        $order = Order::with(["restoran", "user"])
            ->where("id", $orderId)
            ->first();

        $user = User::find($request->user()->id);

        if (is_null($user))
            return response()
                ->json([
                    "message" => "Deliveryman not found!"
                ], 200);

        if (is_null($order))
            return response()
                ->json([
                    "message" => "Order not found!"
                ], 404);

        $order->deliveryman_id = null;
        $order->status = OrderStatusEnum::DeclineByAdmin;
        $order->save();

        $message = sprintf("Заказ *#%s* отклонен!\nКоментарий:%s\nПерезвоните клиенту: %s!",
            $order->id,
            $comment,
            $order->user->phone ?? "Не найден номер телефона"
        );

        $this->sendToTelegram($order->restoran->telegram_channel, $message);

        return response()
            ->json([
                "message" => "Success"
            ], 200);
    }

    public function getDeliverymanOrders(Request $request)
    {
        $orders = Order::with(["details", "restoran", "details.product", "user"])
            ->where("deliveryman_id", $request->user()->id)
            ->get();

        return response()
            ->json([
                "orders" => $orders
            ]);
    }

    public function getOrderById($orderId)
    {
        return Order::with(["restoran", "user", "details", "details.product", "deliveryman"])->where("id", $orderId)->first();
    }

    public function getRange(Request $request, $restId)
    {
        $request->validate([
            'address' => 'required'
        ]);


        $data = YandexGeocodeFacade::setQuery($request->get("address") ?? '')->load();

        $data = $data->getResponse();

        if (is_null($data))
            return response()
                ->json([
                    "range" => 0,
                    "price" => 500,
                    "latitude" => 0,
                    "longitude" => 0
                ]);

        $lat = $data->getLatitude();
        $lon = $data->getLongitude();

        $rest = Restoran::find($restId);

        if (is_null($rest->latitude) || is_null($rest->longitude)) {

            $data = YandexGeocodeFacade::setQuery($rest->adress ?? '')->load();

            $data = $data->getResponse();

            if (!is_null($data)) {
                $lat = $data->getLatitude();
                $lon = $data->getLongitude();

                $rest->latitude = $lat;
                $rest->longitude = $lon;
                $rest->save();
            }

        }

        $range = ($this->calculateTheDistance($lat, $lon, $rest->latitude ?? 0, $rest->longitude ?? 0) / 1000) + 2;

        $price = $range <= 2 ? 50 : ceil(env("BASE_DELIVERY_PRICE") + ($range * env("BASE_DELIVERY_PRICE_PER_KM")));

        return response()
            ->json([
                "range" => floatval(sprintf("%.2f", $range)),
                "price" => $price,
                "latitude" => $lat,
                "longitude" => $lon
            ]);


    }

    public function testOrder()
    {
        $restorans = Restoran::with(["menus"])->get();

        $user = User::where("phone", "+380713007745")->first();

        // $deliveryman = User::where("user_type", \App\Enums\UserTypeEnum::Deliveryman)->first();

        $phone = $user->phone;

        $lat = 48.006239;
        $lon = 37.805177;


        foreach ($restorans as $rest) {

            $range = ($this->calculateTheDistance($lat, $lon, $rest->latitude, $rest->longitude) / 1000);

            $range1 = $range;
            $range2 = $range + 2;

            $price1 = ceil(env("BASE_DELIVERY_PRICE") + ($range1 * env("BASE_DELIVERY_PRICE_PER_KM")));
            $price2 = ceil(env("BASE_DELIVERY_PRICE") + ($range2 * env("BASE_DELIVERY_PRICE_PER_KM")));


            // Log::info("RANGE=$range "." ЦЕНА:".ceil(env("BASE_DELIVERY_PRICE") + ($range * env("BASE_DELIVERY_PRICE_PER_KM"))));


            $order = Order::create([
                'rest_id' => $rest->id,
                'user_id' => $user->id,
                'deliveryman_id' => null,

                'latitude' => $lat,
                'longitude' => $lon,

                'status' => \App\Enums\OrderStatusEnum::InProcessing,

                'delivery_price' => ceil(env("BASE_DELIVERY_PRICE") + ($range2 * env("BASE_DELIVERY_PRICE_PER_KM"))),
                'delivery_range' => floatval(sprintf("%.2f-%.2f", $range1, $range2)),
                'delivery_note' => "Доставить крабиком",

                'receiver_name' => $user->name,
                'receiver_phone' => $user->phone,

                'receiver_delivery_time' => "18:00",
                'receiver_address' => "г.Донецк, ул. Артема, 2а",
                'receiver_order_note' => "TEST",
                'receiver_domophone' => "0000",

                'created_at' => \Carbon\Carbon::now("+3:00")
            ]);

            $menus = $rest->menus->shuffle();

            $limit = random_int(1, min(count($menus), 10));
            $delivery_order_tmp = "";
            $summ = 0;
            foreach ($menus as $product) {

                $order_detail = OrderDetail::create([
                    'product_id' => $product->id,
                    'count' => 5,
                    'price' => $product->food_price,
                    'order_id' => $order->id
                ]);

                $local_tmp = sprintf("#%s %s %s шт. %s руб.\n",
                    $product->id,
                    $product->food_name,
                    5,
                    $product->food_price
                );

                $summ += $product->food_price * 5;

                $delivery_order_tmp .= $local_tmp;

                $limit--;

                if ($limit === 0)
                    break;
            }

            $channel = $rest->telegram_channel;

            $message = sprintf("*Заявка*\nРесторан:_%s_\nФ.И.О.:_%s_\nТелефон:_%s_\nЗаказ:\n%s\nЦена доставки:*%sруб.-%s руб.*(Дистанция:%.2fкм-%.2fкм)\nЦена заказа:*%s руб.*",
                $rest->name,
                $user->name,
                $phone,
                $delivery_order_tmp,
                $price1,
                $price2,
                $range1,
                $range2,
                $summ
            );

            $tmp = "" . $order->id;
            while (strlen($tmp) < 10)
                $tmp = "0" . $tmp;

            $this->sendToTelegram($channel, $message, [
                [
                    ["text" => "Подтвердить заказ!", "url" => "https://t.me/delivery_service_dn_bot?start=001$tmp"],
                    ["text" => "Отменить заказ!", "url" => "https://t.me/delivery_service_dn_bot?start=002$tmp"]
                ]
            ]);

        }
    }

    public function setDeliveredStatus(Request $request, $orderId)
    {

        $order = Order::with(["restoran"])
            ->where("id", $orderId)
            ->first();

        $user = User::find($request->user()->id);

        if (is_null($user))
            return response()
                ->json([
                    "message" => "Deliveryman not found!"
                ], 200);

        if ($user->user_type !== UserTypeEnum::Deliveryman)
            return response()
                ->json([
                    "message" => "You are not deliveryman"
                ], 200);

        if (is_null($order))
            return response()
                ->json([
                    "message" => "Order not found!"
                ], 404);

        if ($order->deliveryman_id !== $user->id)
            return response()
                ->json([
                    "message" => "Order linked with another Deliveryman!"
                ], 200);

        $order->status = OrderStatusEnum::Delivered;
        $order->save();

        $message = sprintf("Доставщик *#%s* успешно доставил заказ *#%s*",
            $user->id,
            $order->id
        );

        $this->sendToTelegram($order->restoran->telegram_channel, $message);

        return response()
            ->json([
                "message" => "Success"
            ], 200);
    }

    public function setCommentToOrder(Request $request, $orderId)
    {
        $order = Order::with(["restoran"])
            ->where("id", $orderId)
            ->first();

        $order->delivery_note = $request->get("comment") ?? '';
        $order->save();


        $user = User::find($request->user()->id);

        $message = sprintf("Администратор *#%s* установил пометку к заказу *#%s*",
            $user->id,
            $order->id
        );

        $this->sendToTelegram($order->restoran->telegram_channel, $message);

        return response()
            ->json([
                "message" => "Success"
            ], 200);
    }

    public function setDeliverymanType(Request $request, $type)
    {
        $user = User::find($request->user()->id);
        $user->deliveryman_type = $type ?? 0;
        $user->save();

        $deliveryman_status_text = "Не установлен";
        switch ($type) {
            case 1:
                $deliveryman_status_text = "Пеший";
                break;
            case 2:
                $deliveryman_status_text = "Велосипед";
                break;
            case 3:
                $deliveryman_status_text = "Мотоцикл";
                break;
            case 4:
                $deliveryman_status_text = "Машина";
                break;
        }

        return response()
            ->json([
                "message" => "Success"
            ], 200);
    }

    public function get()
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            $restoran = Restoran::withTrashed()->where("id", $order->rest_id)->first();
            $order->rest_name = $restoran['name'];
            $order->deliveryman_name = $order->deliveryman_id;
            $order->deliveryman_phone = $order->deliveryman_id;
            if($order->deliveryman_id != null)
            {
                $deliveryman = User::where("id", $order->deliveryman_id)->first();
                $order->deliveryman_phone = $deliveryman['phone'];
                $order->deliveryman_name = $deliveryman['name'];
            }
        }
        $deleted_orders= Order::onlyTrashed()->get();
        return response()
            ->json([
                "orders" => $orders,
                "deleted_orders" => $deleted_orders,
            ], 200);
    }

    public function restore($id)
    {
        $order = Order::onlyTrashed()->where('id', $id)->restore();
        $order_details = OrderDetail::onlyTrashed()->where('order_id', $id)->restore();

        return response()
            ->json([
                "message" => "Заказ восстановлен",
                "status" => 200,
            ]);
    }

    public function getDetails($id)
    {
        $details = OrderDetail::with(["product"])->where("order_id", $id)->get();
        return response()
            ->json([
                "details" => $details,
            ], 200);
    }

}
