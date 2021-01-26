<?php


use App\Conversations\AdminConversation;
use App\Conversations\AnswerQuestionConversation;
use App\Conversations\ConfirmOrderConversation;
use App\Conversations\ConfirmPhotoProjectConversation;
use App\Conversations\FeedbackConversation;
use App\Conversations\FeedbackPPConversation;
use App\Conversations\LotusCampOrderConversation;
use App\Conversations\LotusDanceOrderConversation;
use App\Conversations\MainConversation;
use App\Conversations\ModelFormConversation;
use App\Conversations\PollsFormConversation;
use App\Conversations\QuestionConversation;
use App\Conversations\SearchModelConversation;
use App\Conversations\StartDataConversation;
use App\Conversations\SuperadminConversation;
use App\Conversations\WannaComboPPConversation;
use App\Conversations\WannaFitnessConversation;
use Illuminate\Support\Facades\Log;

$this->hears("/start ([0-9a-zA-Z=]+)", StartDataConversation::class . '::start');

$this->hears("/start|.*Продолжить позже|.*Главное меню|.*Попробовать опять", MainConversation::class . "::start");


$this->hears("/is_work|.*Я работаю", MainConversation::class . "::isWork");
$this->hears("/is_not_work|.*Я не работаю", MainConversation::class . "::isNotWork");
$this->hears("/change_type|.*Сменить статус", MainConversation::class . "::changeUserType");
$this->hears("/faq|.*Как пользоваться", MainConversation::class . "::faq");
$this->hears("/day|.*Заказы за день", MainConversation::class . "::day");
$this->hears("/self|.*Моя доставка", MainConversation::class . "::myDeliveryOrders");

$this->hears("/pdf|.*PDF-сводка за день", SuperadminConversation::class . "::generatePdf");
$this->hears("/all|.*Все заказы за день", SuperadminConversation::class . "::allDayOrders");
$this->hears("/deliveryman_list|.*Доставщики", SuperadminConversation::class . "::deliverymanList");
$this->hears("/admin_list|.*Администраторы", SuperadminConversation::class . "::adminList");
$this->hears("/refresh_all_keywords|.*Обновить все ключи", SuperadminConversation::class . "::refreshAllKeywords");
$this->hears("/complete_day_orders ([0-9]+)", SuperadminConversation::class . "::completeDayOrders");
$this->hears("/unset_user_type ([0-9]+)", SuperadminConversation::class . "::unsetUserType");
$this->hears("/change_summary_price ([0-9]+)", SuperadminConversation::class . "::changeSummaryPrice");
$this->hears("/change_delivery_price ([0-9]+)", SuperadminConversation::class . "::changeDeliveryPrice");


$this->hears("/accept_order ([0-9]+)", MainConversation::class . "::acceptOrder");
$this->hears("/decline_order_dialog ([0-9]+)", MainConversation::class . "::declineOrderDialog");
$this->hears("/accept_time_order ([0-9]+) ([0-9]+)", MainConversation::class . "::acceptOrder");
$this->hears("/set_time_and_accept ([0-9]+)", MainConversation::class . "::setTimeAndAccept");
$this->hears("/decline_order ([0-9]+)", MainConversation::class . "::declineOrder");
$this->hears("/decline_delivery ([0-9]+)", MainConversation::class . "::declineOrder");
$this->hears("/delivered ([0-9]+)", MainConversation::class . "::delivered");



$this->fallback(function ($bot) {
    $arr = [
      "Ой-ой! А что это вы у меня спрашиваете? Попробуйте /start !",
      "Хм, я что-то не могу понять о чем речь? Попробуйте /start !",
      "Может быть попробовать по другому? Может быть /start ?",
      "Лучше воспользоваться меню /start - так надежней!",
      "Ваш язык мне не понятен:( Попробуйте /start",
      "Возможно, вы имели ввиду /start ?",
    ];

    $bot->reply($arr[array_rand($arr)]);
});
