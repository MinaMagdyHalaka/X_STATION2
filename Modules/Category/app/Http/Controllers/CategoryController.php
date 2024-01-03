<?php

namespace Modules\Category\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Category\app\Resources\CategoryResource;
use Modules\Category\Service\categoryService;
use Modules\Technical\app\Resources\TechnicalResource;

class CategoryController extends Controller
{
    use HttpResponse;
    public static string $collectionName = 'category';

    public function __construct(private readonly categoryService $categoryService)
    {
    }

    public function index()
    {
        $result = $this->categoryService->index();

        return $this->resourceResponse(CategoryResource::collection($result));
    }

    public function store(Request $request): RedirectResponse
    {
        //
    }

    public function show($id)
    {
        return view('category::show');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
