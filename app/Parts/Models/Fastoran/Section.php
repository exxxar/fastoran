<?php

namespace App\Parts\Models\Fastoran;

use App\Enums\ContentTypeEnum;
use App\Enums\UserTypeEnum;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use CastsEnums, SoftDeletes;
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
        return $this->restorans()->count();
    }

    public function restorans()
    {
        return $this->belongsToMany(Restoran::class, 'restorans_in_section', 'section_id', 'restoran_id')
            ->withTimestamps();
    }

}
