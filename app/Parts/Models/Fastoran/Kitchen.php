<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    //
    protected $table = "kitchen";

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
