<?php

namespace App;

use App\Enums\ContentTypeEnum;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use CastsEnums;

    protected $enumCasts = [
        'content_type' => ContentTypeEnum::class,
    ];

    protected $fillable = [
        'like_count',
        'dislike_count',
        'user_ip',
        'content_type',
        'content_id',
    ];


}
