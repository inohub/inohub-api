<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Repositories\Role\RoleRepository;
use Illuminate\Http\Request;

/**
 * Class RoleController
 * @property RoleRepository $roleRepository
 * @package App\Http\Controllers\Api\Role
 */
class RoleController extends Controller
{
    private RoleRepository $roleRepository;

    /**
     * RoleController constructor.
     *
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->roleRepository->doFilter($request);

        return $this->response($builder->get());
    }
}
