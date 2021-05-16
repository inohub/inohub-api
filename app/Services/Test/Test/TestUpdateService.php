<?php

namespace App\Services\Test\Test;

use App\Components\Request\DataTransfer;
use App\Models\Test\Test;

/**
 * Class TestUpdateService
 * @property Test         $test
 * @property DataTransfer $request
 * @package App\Services\Test
 */
class TestUpdateService
{
    private Test $test;
    private DataTransfer $request;

    /**
     * TestUpdateService constructor.
     *
     * @param Test         $test
     * @param DataTransfer $request
     */
    public function __construct(Test $test, DataTransfer $request)
    {
        $this->test = $test;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->test->name = $this->request->post('name');

        return $this->test->save();
    }
}
