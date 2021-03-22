<?php

namespace App\Search\Base;

use App\Components\Response\Serializer;
use App\Components\Rules\SearchValidateIntegerRule;
use App\Search\Base\Filters\Id;
use App\Search\Base\Filters\NotId;
use App\Search\Base\Filters\Sort;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

/**
 * Class BaseSearch
 * @package App\Search\Base
 */
abstract class BaseSearch
{
    protected $modelClass;
    protected $request;
    protected $sort = [];
    protected $commonFilters = [
        'Id'    => Id::class,
        'NotId' => NotId::class,
        'Sort'  => Sort::class,
    ];
    protected $expandWith = [];
    protected $expandCount = [];
    protected $except = [];
    protected $only = [];
    protected $hiddenFilters = [];
    protected $data = [];

    /**
     * Search constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    abstract protected function getNameSpace(): string;

    /**
     * @return Builder|mixed
     */
    public function query()
    {
        $this->setData();
        if ($this->validationFail()) {
            return app($this->modelClass)->newQuery()->whereRaw('0=1');
        }
        return $this->applyDecoratorsFromRequest();
    }

    /**
     * @return mixed
     */
    protected function applyDecoratorsFromRequest()
    {
        $query = app($this->modelClass)->newQuery();

        foreach ($this->data as $filterName => $value) {
            if ($filterName == 'sort') {
                continue;
            }

            $decorator = $this->createFilterDecorator($filterName);
            if ($this->isValidDecorator($decorator)) {
                $decorator::apply($query, $value);
            }
        }

        foreach ((array)$this->request->query('sort', []) as $value) {
            $decorator = $this->createFilterDecorator('sort');

            if ($this->isValidDecorator($decorator) && $this->isValidSort($value)) {
                $decorator::apply($query, $value);
            }
        }

        return $this->expandFilter($query);
    }

    private function setData()
    {
        $data = [];
        foreach ((array)$this->request->query('search', []) as $key => $item) {
            $data[snake_case($key)] = $item;
        }

        if ($this->only) {
            $data = Arr::only($data, $this->only);
        } elseif ($this->except) {
            $data = Arr::except($data, $this->except);
        }

        $this->data = $data;
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    public function setExpandWith(array $value)
    {
        $this->expandWith = $value;
        return $this;
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    public function setExpandCount(array $value)
    {
        $this->expandCount = $value;
        return $this;
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    public function setExcept(array $value)
    {
        $this->except = $value;
        return $this;
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    public function setOnly(array $value)
    {
        $this->only = $value;
        return $this;
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    public function setHiddenFilters(array $value)
    {
        $this->hiddenFilters = $value;
        return $this;
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    private function expandFilter(Builder $query)
    {
        $expand = app(Serializer::class)->getExpandFields();

        $with = [];
        $count = [];

        if ($expand) {
            $with = Arr::collapse(array_intersect_key($this->expandWith, array_flip($expand)));
            $count = Arr::collapse(array_intersect_key($this->expandCount, array_flip($expand)));
        }

        return $query->with($with)->withCount($count);
    }

    /**
     * @return bool
     */
    private function validationFail(): bool
    {
        if ($this->data && $this->validationRules()) {
            $validator = Validator::make($this->data, $this->validationRules());
            return $validator->fails();
        }

        return false;
    }

    /**
     * @return SearchValidateIntegerRule[]
     */
    protected function validationRules(): array
    {
        return [
            "id" => new SearchValidateIntegerRule()
        ];
    }

    /**
     * @param $name
     *
     * @return string
     */
    private function createFilterDecorator($name)
    {
        $name = studly_case($name);

        if (Arr::has($this->commonFilters, $name)) {
            return $this->commonFilters[$name];
        } elseif ($this->hiddenFilters && in_array($name, $this->hiddenFilters)) {
            return $this->getNameSpace() . '\\HiddenFilters\\' . studly_case($name);
        }

        return $this->getNameSpace() . '\\Filters\\' . $name;
    }

    /**
     * @param $decorator
     *
     * @return bool
     */
    private function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    /**
     * @param $sort
     *
     * @return bool
     */
    private function isValidSort($sort)
    {
        return in_array($sort, $this->sort);
    }
}
