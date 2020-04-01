<?php

namespace App\Parts\Models\Fastoran;

use App\Enums\ContentTypeEnum;
use App\Enums\UserTypeEnum;
use App\Rating;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    use CastsEnums;

    protected $enumCasts = [
        'user_type' => UserTypeEnum::class,
    ];

    protected $fillable = [
        'name',
        'img',
        'view',
        'alt_description'
    ];

    protected $hidden = [
        "created_at","updated_at"
    ];

    protected $appends = ["rest_count","rating"];

    public function getRestCountAttribute(){
        return 0;
    }

    public function restorans()
    {
        return $this->belongsToMany(Restoran::class, 'kitchen_in_restorans', 'kitchen_id', 'restoran_id')
            ->withTimestamps();
    }

    public function getRatingAttribute()
    {
        return Rating::where("content_type", ContentTypeEnum::Kitchen)
            ->select(["dislike_count","like_count"])
            ->where('content_id', $this->id)
            ->first();
    }
}
