<?php

namespace App\Http\Controllers\Api\Lists;

use App\Http\Controllers\Controller;
use App\StartupStatus\StartupStatus;

/**
 * Class ListsController
 * @package App\Http\Controllers\Api\Lists
 */
class ListsController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function startupStatus()
    {
        return $this->response(StartupStatus::getDescription());
    }
}
