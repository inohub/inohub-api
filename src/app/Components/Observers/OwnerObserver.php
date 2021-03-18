<?php

namespace App\Components\Observers;

use App\Components\Interfaces\OwnerInterface;

class OwnerObserver
{
    public function creating(OwnerInterface $model)
    {
        $model->owner_id = $model->owner_id ?: \Auth::id();
    }
}
