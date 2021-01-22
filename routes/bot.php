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
use App\Conversations\WannaComboPPConversation;
use App\Conversations\WannaFitnessConversation;
use Illuminate\Support\Facades\Log;

$this->hears("/start ([0-9a-zA-Z=]+)", StartDataConversation::class . '::start');
$this->hears("/start|.*Продолжить позже|.*Главное меню|.*Попробовать опять", MainConversation::class . "::start");
$this->hears("/current_profile", MainConversation::class . "::currentProfile");
$this->hears("/product_list ([0-9]+)|.*Фирменная продукция", MainConversation::class . "::brandedGoods");
$this->hears("/lma_courses_list ([0-9]+)|.*Курсы LMA", MainConversation::class . "::lmaCourses");
$this->hears("/lkc_courses_list ([0-9]+)|.*Курсы LKC", MainConversation::class . "::lkcCourses");
$this->hears("/equipment_rent_list ([0-9]+)|.*Аренда помещений . оборудования", MainConversation::class . "::equipmentRent");
$this->hears("/add_to_cart ([0-9]+)", MainConversation::class . "::addProductToCart",false);
$this->hears("/more_info ([0-9]+)", MainConversation::class . "::moreInfo");
$this->hears("/.Посмотреть мои товары", MainConversation::class . "::showProductInCart");
$this->hears("/.Фотопроекты на месяц", MainConversation::class . "::monthPhotoprojects");
$this->hears("/show_cart|.*Корзина.([0-9]+).", MainConversation::class . "::cart");
$this->hears("/.*Очистить корзину", MainConversation::class . "::clearCart");

$this->hears("/.*Lotus Model Agency", MainConversation::class . "::lmaMenu");
$this->hears("/.*Lotus Photostudio", MainConversation::class . "::lpMenu");
$this->hears("/.*Lotus Camp", MainConversation::class . "::lcMenu");
$this->hears("/.*Lotus Dance", MainConversation::class . "::ldMenu");
$this->hears("/.*Lotus Kids", MainConversation::class . "::lkMenu");
$this->hears("/.*Combo Photoproject", MainConversation::class . "::lcpMenu");

$this->hears("/.*Перейти в канал ([a-zA-Z]+)", MainConversation::class . "::goToChannel");
$this->hears("/.*Найти модель", MainConversation::class . "::findModel");
$this->hears("/.*F.A.Q.", MainConversation::class . "::askQuestion");

$this->hears("/user_profile|.*Мой профиль", MainConversation::class . "::profile");



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
