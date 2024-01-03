<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Technical\app\Models\Technical;
use Modules\User\Http\Controllers\UserController;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable,Searchable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'type',
        'average_rating',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

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
    public function technical(): HasOne
    {
        return $this->hasOne(Technical::class,'user_id');
    }

    public function rating(): MorphMany
    {
        return $this->morphMany(Rate::class,'rateable');
    }

    public function favorite(): MorphMany
    {
        return $this->morphMany(Favorite::class,'favoritable');
    }
}
