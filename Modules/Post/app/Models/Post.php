<?php

namespace Modules\Post\app\Models;

use App\Helpers\MediaHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Post\app\Http\Controllers\PostController;
use Modules\Technical\app\Models\Technical;
use Modules\Technical\Enums\ApplicantEnum;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['user_id', 'title', 'description'];
    protected $hidden = ['pivot'];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(PostController::$collectionName)
            ->singleFile();
    }

    public function image(): MorphMany
    {
        return $this->media()->where('collection_name', PostController::$collectionName)
        ->select(['id', 'model_id', 'disk', 'file_name']);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function technicals(): BelongsToMany
    {
        return $this->belongsToMany(Technical::class, 'applications','post_id','technical_id')
            ->withPivot('status');
    }

    public function accepted(): BelongsToMany
    {
        return $this->belongsToMany(Technical::class, 'applications','post_id','technical_id')
            ->withPivot('status')
            ->wherePivot('status',ApplicantEnum::ACCEPTED);
    }
}
