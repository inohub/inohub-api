<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryCreateRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category\Category;
use App\Repositories\Category\CategoryRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Category\CategoryCreateService;
use App\Services\Category\CategoryUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParams()
    {
        return $this->response([
            'fields' => $this->categoryRepository->fields,
            'relations' => $this->categoryRepository->relations
        ]);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->categoryRepository->filters($request);

        return $this->response($builder->get());
    }

    /**
     * @param  CategoryCreateRequest  $request
     * @param  Category  $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CategoryCreateRequest $request, Category $category)
    {
        DB::beginTransaction();

        try {

            if ((new CategoryCreateService($category, $request))->run()) {

                DB::commit();

                return $this->response($category->refresh());
            }

            throw (new HttpException(ResponseCodes::BAD_REQUEST));

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Category $category
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category, Request $request)
    {
        $builder = $this->categoryRepository->filters($request, $category);

        return $this->response($builder->get());
    }

    /**
     * @param CategoryUpdateRequest $request
     * @param Category              $category
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {

        DB::beginTransaction();

        try {

            if ((new CategoryUpdateService($category, $request))->run()) {

                DB::commit();

                return $this->response($category->refresh());
            }

            throw (new HttpException(ResponseCodes::BAD_REQUEST));

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Category $category
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->response([]);
    }
}
