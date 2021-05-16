<?php

namespace App\Services\Category;

use App\Components\Request\DataTransfer;
use App\Models\Category\Category;

/**
 * Class CategoryCreateService
 * @property Category     $category
 * @property DataTransfer $request
 * @package App\Services\Category
 */
class CategoryCreateService
{
    private Category $category;
    private DataTransfer $request;

    /**
     * StartupCreateService constructor.
     *
     * @param Category     $category
     * @param DataTransfer $request
     */
    public function __construct(Category $category, DataTransfer $request)
    {
        $this->category = $category;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->category->title = $this->request->post('title');
        $this->category->description = $this->request->post('description');
        $this->category->parent_id = $this->request->post('parent_id');

        return $this->category->save();
    }
}
