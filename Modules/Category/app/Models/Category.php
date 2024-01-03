<?php

namespace Modules\Category\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Category\app\Http\Controllers\CategoryController;
use Modules\Technical\app\Models\Technical;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = ['name'];

    public function image(): MorphMany
    {
        return $this->media()->where('collection_name', CategoryController::$collectionName)
            ->select(['id', 'model_id', 'disk', 'file_name']);
    }

    public function technicals(): HasMany
    {
        return $this->hasMany(Technical::class, 'category_id');
    }
}
