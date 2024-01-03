<?php

namespace Modules\Technical\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\app\Resources\CategoryResource;
use Modules\User\Transformers\UserResource;

class TechnicalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'user' => UserResource::make($this->whenLoaded('user')),
            'is_favorite' => $this->whenLoaded('favorite'),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'status' => $this->whenPivotLoaded('applications', function () {
                return $this->pivot->status;
            }),
        ];
    }
}
