<?php

namespace App\Http\Controllers\Api\Startup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Startup\StartupCreateRequest;
use App\Models\Startup\Startup;
use App\Repositories\Startup\StartupRepository;
use Illuminate\Http\Request;

/**
 * Class StartupController
 * @property StartupRepository $startupRepository
 * @package App\Http\Controllers\Api\Startup
 */
class StartupController extends Controller
{
    private StartupRepository $startupRepository;

    /**
     * StartupController constructor.
     *
     * @param StartupRepository $startupRepository
     */
    public function __construct(StartupRepository $startupRepository)
    {
        $this->startupRepository = $startupRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->startupRepository->search($request);

        return $this->response($builder->query()->get());
    }


    public function store(StartupCreateRequest $request, Startup $startup)
    {
        dd($request->post(), $startup);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
