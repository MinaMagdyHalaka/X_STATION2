<?php

namespace Modules\Post\app\Resources;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Technical\app\Resources\TechnicalResource;
use Modules\User\Transformers\UserResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $userId = auth()->id();
        return [
            'id' => $this->id,
            'title' => $this->whenHas('title'),
            'description' => $this->whenHas('description'),
            'image' => $this->whenLoaded('image', $this->image->first()->original_url ?? null),
            'my_post' => $this->user_id == $userId,
            'user' => UserResource::make($this->whenLoaded('user')),
            'is_applied' => $this->when($this->relationLoaded('technicals'), function (){
                return $this->technicals->isEmpty() ? 0 : 1;
            }),
            'job_taken' => $this->when($this->relationLoaded('accepted'), function (){
                return $this->accepted->isEmpty() ? 0 : 1;
            }),
            'all_applied' => TechnicalResource::collection($this->whenLoaded('technicals')),
        ];
    }
}
