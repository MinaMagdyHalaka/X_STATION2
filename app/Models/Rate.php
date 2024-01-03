<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rate extends Model
{
    protected $fillable = ['user_id','rateable_id','rateable_type','rate'];
    protected $table = 'rates';

    public function rateable(): MorphTo
    {
        return $this->morphTo();
    }
}
