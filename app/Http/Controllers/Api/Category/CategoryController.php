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
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->categoryRepository->doFilter($request);

        return $this->response($builder->get());
    }

    /**
     * @param CategoryCreateRequest $request
     * @param Category              $category
     *
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

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Category $category
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return $this->response($category);
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

            return $this->response([], ResponseCodes::FAILED_RESULT);

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
