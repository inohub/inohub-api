<?php

namespace App\Components\Observers;

use App\Interfaces\Base\OwnerInterface;

/**
 * Class OwnerObserver
 * @package App\Components\Observers
 */
class OwnerObserver
{
    /**
     * @param OwnerInterface $model
     */
    public function creating(OwnerInterface $model)
    {
        $model->owner_id = $model->owner_id ?: \Auth::id();
    }
}
