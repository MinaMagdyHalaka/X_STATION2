<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Modules\Category\app\Models\Category;

class SelectMenuController extends Controller
{
    use HttpResponse;
    public function categories()
    {
        return $this->resourceResponse(
            Category::latest()->get(['id', 'name'])
        );
    }
}
