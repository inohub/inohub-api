<?php

namespace App\Services\Test\Variant;

use App\Models\Test\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class VariantUpdateService
 * @property Variant $variant
 * @property Request $request
 * @package App\Services\Test\Variant
 */
class VariantUpdateService
{
    private Variant $variant;
    private Request $request;

    /**
     * VariantUpdateService constructor.
     *
     * @param Variant $variant
     * @param Request $request
     */
    public function __construct(Variant $variant, Request $request)
    {
        $this->variant = $variant;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $data = $this->request->post();

        $this->variant->fill([
            'text'       => Arr::get($data, 'text'),
            'is_correct' => Arr::get($data, 'is_correct', false),
        ]);

        return $this->variant->save();
    }
}
