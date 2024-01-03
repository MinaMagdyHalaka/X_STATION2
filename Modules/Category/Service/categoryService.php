<?php

namespace Modules\Category\Service;

use Modules\Category\app\Models\Category;

class categoryService
{
    public Category $categoryModel;
    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index()
    {
        return $this->categoryModel::with('image')->get();
    }

    public function categoryExists($categoryId, &$errors, $errorKey = 'category_id')
    {
        $category = $this->categoryModel::whereId($categoryId)->first();
        if (!$category){
            $errors[$errorKey] = translate_error_message('category', 'not_exists');
        }
        return $category;
    }
}
