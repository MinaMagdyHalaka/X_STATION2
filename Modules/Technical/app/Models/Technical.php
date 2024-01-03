<?php

namespace Modules\Technical\app\Models;

use App\Models\Favorite;
use App\Models\User;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Category\app\Models\Category;
use Modules\Post\app\Models\Post;
use Modules\User\Http\Controllers\UserController;

class Technical extends Model
{
    use Searchable;
    protected $fillable = [];
    protected $hidden = ['pivot'];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(UserController::$collectionName)
            ->singleFile();
    }

    public function avatar(): MorphMany
    {
        return $this->media()->where('collection_name', UserController::$collectionName)
            ->select(['id', 'model_id', 'disk', 'file_name']);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class,'applications','technical_id','post_id')
            ->withPivot('status');
    }

    public function favorite(): MorphMany
    {
        return $this->morphMany(Favorite::class,'favoritable');
    }
}
