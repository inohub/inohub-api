<?php

namespace App\Services\Test\Variant;

use App\Components\Request\DataTransfer;
use App\Models\Test\Variant;

/**
 * Class VariantUpdateService
 * @property Variant      $variant
 * @property DataTransfer $request
 * @package App\Services\Test\Variant
 */
class VariantUpdateService
{
    private Variant $variant;
    private DataTransfer $request;

    /**
     * VariantUpdateService constructor.
     *
     * @param Variant      $variant
     * @param DataTransfer $request
     */
    public function __construct(Variant $variant, DataTransfer $request)
    {
        $this->variant = $variant;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->variant->text = $this->request->post('text');
        $this->variant->is_correct = $this->request->post('is_correct', false);

        return $this->variant->save();
    }
}
