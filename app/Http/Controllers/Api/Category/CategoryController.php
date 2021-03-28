<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 * @property CategoryRepository $categoryRepository
 * @package App\Http\Controllers\Api\Category
 */
class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;

    /**
     * StartupController constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getParams()
    {
        return $this->response();
    }
}
