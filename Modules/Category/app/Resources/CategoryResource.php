<?php

namespace Modules\Category\app\Resources;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => ResourceHelper::getFirstMediaOriginalUrl($this, 'image', 'category.jpeg'),
        ];
    }
}
