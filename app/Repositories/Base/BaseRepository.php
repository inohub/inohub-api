<?php

namespace App\Repositories\Base;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BaseRepository
 * @property Builder $builder
 * @property array   $data
 * @property array   $fields
 * @package App\Repositories\Base
 */
abstract class BaseRepository
{
    protected Builder $builder;
    private array $data;
    public array $fields;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->builder = app($this->getModelClass())->query();
        $this->fields = array_merge(app($this->getModelClass())->getFillable(), ['id', 'created_at', 'updated_at']);
    }

    /**
     * @param Request $request
     *
     * @return Builder
     */
    public function filters(Request $request)
    {
        $this->data = $request->all();

        if (isset($this->data['searches'])) {
            $this->search();
        }

        if (isset($this->data['fields'])) {
            $this->setFields();
        }

        if (isset($this->data['sorts'])) {
            $this->sort();
        }

        if (isset($this->data['relations'])) {
            $this->setRelations();
        }

        if (isset($this->data['relations_count'])) {
            $this->setRelationsCount();
        }

        return $this->builder;
    }

    private function search()
    {
        $searches = $this->data['searches'];

        foreach ($searches as $key => $value) {
            if (isset($this->filters[$key])) {
                if ($this->serches[$key] == 'LIKE') {
                    $value = '%' . $value . '%';
                }
                $this->builder->where($key, $this->serches[$key], $value);
            }
        }
    }

    private function sort()
    {
        $sorts = $this->data['sorts'];

        foreach ($sorts as $key => $value) {
            if (in_array($key, $this->fields)) {
                $this->builder->orderBy($key, $value);
            }
        }
    }

    private function setFields()
    {
        $fields = $this->data['fields'];

        foreach ($fields as $field) {
            if (in_array($field, $this->fields)) {
                $this->builder->addSelect($field);
            }
        }
    }

    private function setRelations()
    {
        $relations = $this->data['relations'];

        foreach ($relations as $key => $value) {
            if (isset($this->relations[$key])) {
                if (str_plural($key, 2) == $key) {
                    $value[] = $this->relations[$key];
                } else {
                    $this->builder->addSelect($this->relations[$key]);
                }
                $this->builder->with($key . ':' . implode(',', $value));
            }
        }
    }

    private function setRelationsCount()
    {
        $relationsCount = $this->data['relations_count'];

        foreach ($relationsCount as $item) {
            if (isset($this->relations[$item])) {
                $this->builder->withCount($item);
            }
        }
    }
}
