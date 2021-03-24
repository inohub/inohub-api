<?php

namespace App\Traits\SetWithRelations;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Trait SetWithRelations
 * @package App\Traits\SetWithRelations
 */
trait SetWithRelations
{
    /**
     * @param Request $request
     *
     * @return $this
     */
    public function setResponseFields(Request $request)
    {
        $data = $request->all();
        $data['fields'][] = 'id';

        $this->setVisible(Arr::get($data, 'fields'))
            ->setWithRelations(Arr::get($data, 'relations', []));

        return $this;
    }

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
