<?php

namespace Modules\Technical\app\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['technical_id', 'post_id','status'];

}
