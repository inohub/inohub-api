<?php

namespace App\Services\Test\Test;

use App\Models\Test\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class TestCreateService
 * @property Test    $test
 * @property Request $request
 * @package App\Services\Test
 */
class TestCreateService
{
    private Test $test;
    private Request $request;

    /**
     * TestCreateService constructor.
     *
     * @param Test    $test
     * @param Request $request
     */
    public function __construct(Test $test, Request $request)
    {
        $this->test = $test;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $data = $this->request->post();

        $this->test->fill([
            'lesson_id' => Arr::get($data, 'lesson_id'),
            'name'      => Arr::get($data, 'name'),
        ]);

        return $this->test->save();
    }
}
