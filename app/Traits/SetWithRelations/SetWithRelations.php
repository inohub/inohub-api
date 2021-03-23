<?php

namespace App\Traits\SetWithRelations;

/**
 * Trait SetWithRelations
 * @package App\Traits\SetWithRelations
 */
trait SetWithRelations
{
    /**
     * @param $relations
     *
     * @return $this
     */
    public function setWithRelations($relations)
    {
        foreach ($relations as $key => $value) {
            $this->setRelation($key, $this->$key->setVisible($value));
        }
        return $this;
    }
}
