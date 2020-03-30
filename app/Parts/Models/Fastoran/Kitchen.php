<?php

namespace App\Parts\Models\Fastoran;

use App\Enums\UserTypeEnum;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    //
    use CastsEnums;

    protected $enumCasts = [
        // 'attribute_name' => Enum::class
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

    protected $appends = ["rest_count"];

    public function getRestCountAttribute(){
        return 0;
    }

    public function restorans()
    {
        return $this->belongsToMany(Restoran::class, 'kitchen_in_restorans', 'restoran_id', 'kitchen_id')
            ->withTimestamps();
    }
}
