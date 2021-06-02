<?php

namespace App\Repositories\Base;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

/**
 * Class BaseRepository
 * @property Builder $builder
 * @property array   $relations
 * @property         $model
 * @package App\Repositories\Base
 */
abstract class BaseRepository
{
    const SET_SELF_RELATION_TYPE = ['belongsTo'];
    private Builder $builder;
    private array $relations;
    private $model;
    protected $perPage = 10;

    /**
     * @return string
     */
    abstract protected function getModelClass(): string;

    /**
     * @return array
     */
    abstract protected function getRelations(): array;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
        $this->builder = app($this->getModelClass())->query();
        $this->relations = $this->getRelations();
    }

    /**
     * @return mixed
     */
    public function startQuery()
    {
        return $this->model->query()->withoutGlobalScopes();
    }

    /**
     * @param string $table
     * @param array  $columns
     *
     * @throws NotFoundException
     */
    private function checkColumns(string $table, array $columns)
    {
        if (!Schema::hasColumns($table, $columns)) {
            foreach ($columns as $column) {
                if (!Schema::hasColumn($table, $column)) {
                    throw new NotFoundException('Not found ' . $column . ' column in table ' . $table);
                }
            }
        }
    }

    /**
     * @param array $relations
     *
     * @throws NotFoundException
     */
    private function checkRelations(array $relations)
    {
        foreach ($relations as $relation) {
            if (!array_key_exists($relation, $this->relations)) {
                throw new NotFoundException('Not found ' . $relation . ' relation');
            }
        }
    }

    /**
     * @param Request $request
     *
     * @return Builder|mixed
     */
    public function doFilter(Request $request)
    {
        $this->builder = $this->fieldsBuilder($this->builder, $request->post('fields', []));
        $this->builder = $this->sortBuilder($this->builder, $request->post('sort', []));
        $this->builder = $this->searchBuilder($this->builder, $request->post('search', []));
        $this->builder = $this->countBuilder($this->builder, $request->post('count', []));
        $this->builder = $this->relationBuilder($this->builder, $request->post('relation', []), $request->post('fields', []));

        return $this->builder;
//            ->skip($this->perPage * ($request->post('page') - 1))->take($this->perPage);
    }

    /**
     * @param       $builder
     * @param array $fields
     *
     * @return mixed
     * @throws NotFoundException
     */
    private function fieldsBuilder($builder, array $fields)
    {
        $this->checkColumns($builder->getModel()->getTable(), $fields);

        if (count($fields)) {
            $builder->select($fields);
        }

        return $builder;
    }

    /**
     * @param       $builder
     * @param array $sort
     *
     * @return mixed
     * @throws NotFoundException
     */
    private function sortBuilder($builder, array $sort)
    {
        $this->checkColumns($builder->getModel()->getTable(), array_keys($sort));

        foreach ($sort as $key => $value) {
            $builder->orderBy($key, $value);
        }

        return $builder;
    }

    /**
     * @param       $builder
     * @param array $search
     *
     * @return mixed
     * @throws NotFoundException
     */
    private function searchBuilder($builder, array $search)
    {
        $this->checkColumns($builder->getModel()->getTable(), array_keys($search));

        foreach ($search as $key => $value) {
            switch ($value['operator']) {
                case 'like':
                    $builder->where($key, 'LIKE', $value['value']);
                    break;
                case 'exact':
                    $builder->whereIn($key, $value['value']);
                    break;
            }
        }

        return $builder;
    }

    /**
     * @param       $builder
     * @param array $count
     *
     * @return mixed
     * @throws NotFoundException
     */
    private function countBuilder($builder, array $count)
    {
        $this->checkRelations($count);

        foreach ($count as $value) {
            $builder->withCount($value);
        }

        return $builder;
    }

    /**
     * @param       $builder
     * @param array $relations
     * @param array $baseFields
     *
     * @return mixed
     * @throws NotFoundException
     */
    private function relationBuilder($builder, array $relations, array $baseFields)
    {
        $this->checkRelations(array_keys($relations));

        foreach ($relations as $key => $value) {
            if (in_array($this->relations[$key][0], self::SET_SELF_RELATION_TYPE) && count($baseFields)) {
                $baseFields[] = $this->relations[$key][1];
                $builder = $this->fieldsBuilder($builder, $baseFields);
            }

            if (!count($value)) {

                $builder->with($key);

            } else {

                $fields = Arr::get($value, 'fields', []);
                $search = Arr::get($value, 'search', []);

                if (!in_array($this->relations[$key][0], self::SET_SELF_RELATION_TYPE) && count($fields)) {
                    $fields[] = $this->relations[$key][1];
                }

                $builder->with($key, function ($builder) use ($fields) {
                    $this->fieldsBuilder($builder, $fields);
                });

                $builder->whereHas($key, function ($builder) use ($search) {
                    $this->searchBuilder($builder, $search);
                });
            }
        }

        return $builder;
    }
}
