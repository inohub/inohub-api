<?php


namespace App\Services\Category;


use App\Models\Category\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CategoryUpdateService
{
    private Category $category;
    private Request $request;

    /**
     * StartupCreateService constructor.
     *
     * @param Category $category
     * @param Request $request
     */
    public function __construct(Category $category, Request $request)
    {
        $this->category = $category;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $data = $this->request->post();

        $this->category->title = Arr::get($data, 'title');
        $this->category->description = Arr::get($data, 'description');
        $this->category->parent_id = Arr::get($data, 'parent_id', null);

        return $this->category->save();
    }
}
