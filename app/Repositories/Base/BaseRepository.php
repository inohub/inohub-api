<?php

namespace App\Repositories\Base;

use App\Interfaces\BaseRepository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class BaseRepository
 * @property Builder $builder
 * @property         $fields
 * @property         $relations
 * @property         $searchFields
 * @property         $fieldsFromRequest
 * @package App\Repositories\Base
 */
abstract class BaseRepository implements BaseRepositoryInterface
{
    const RELATION_TYPE = ['belongsTo'];

    private Builder $builder;
    private array $fields;
    private array $relations;
    private array $searchFields;
    private array $fieldsFromRequest;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->builder = app($this->getModelClass())->query();
        $this->fields = array_merge(app($this->getModelClass())->getFillable(), ['created_at', 'updated_at']);
        $this->relations = app($this->getModelClass())->getRelations();
        $this->searchFields = $this->getSearchFields();
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return [
            'fields'    => $this->fields,
            'relations' => array_keys($this->relations),
        ];
    }

    /**
     * @param Request $request
     *
     * @return Builder
     */
    public function filters(Request $request)
    {
        $data = $request->post();

        $this->search(Arr::get($data, 'search', []));
        $this->sort(Arr::get($data, 'sort', []));
        $this->setForAll($data);

        return $this->builder;
    }

    /**
     * @param Request $request
     * @param Model   $model
     *
     * @return Builder
     */
    public function findOne(Request $request, Model $model)
    {
        $data = $request->post();

        $this->builder->where('id', $model->id);
        $this->setForAll($data);

        return $this->builder;
    }

    /**
     * @param $data
     */
    private function setForAll($data)
    {
        $this->setFields(Arr::get($data, 'fields', []));
        $this->setRelationCount(Arr::get($data, 'count', []));
        $this->setRelations(Arr::get($data, 'relation', []));
        $this->select();
    }

    /**
     * @param $data
     */
    private function search($data)
    {
        foreach ($data as $key => $value) {
            if (isset($this->searchFields[$key])) {
                $value = $value == 'LIKE' ? '%' . $value . '%' : $value;
                $this->builder->where($key, $this->searchFields[$key], $value);
            }
        }
    }

    /**
     * @param $data
     */
    private function sort($data)
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fields) || $key == 'id') {
                $this->builder->orderBy($key, $value);
            }
        }
    }

    /**
     * @param $data
     */
    private function setRelationCount($data)
    {
        foreach ($data as $value) {
            if (isset($this->relations[$value])) {
                $this->builder->withCount($value);
            }
        }
    }

    /**
     * @param $data
     */
    private function setRelations($data)
    {
        foreach ($data as $key => $value) {
            if (isset($this->relations[$key])) {

                $fields = Arr::get($value, 'fields', []);
                $query = $key;

                if (in_array($this->relations[$key][0], self::RELATION_TYPE)) {
                    $this->fieldsFromRequest[] = $this->relations[$key][1];
                } elseif ($fields) {
                    $fields[] = $this->relations[$key][1];
                }

                if ($fields) {
                    $query = $query . ':id,' . implode(',', $fields);
                }

                $this->builder->with($query);
            }
        }
    }

    /**
     * @param $data
     */
    private function setFields($data)
    {
        if ($data) {
            $this->fieldsFromRequest = $data;
        } else {
            $this->fieldsFromRequest = $this->fields;
        }
    }

    private function select()
    {
        array_unshift($this->fieldsFromRequest, 'id');
        $this->builder->select($this->fieldsFromRequest);
    }
}
