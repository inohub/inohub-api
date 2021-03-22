<?php

namespace App\Repositories\Base;

use App\Components\Rules\SearchValidateIntegerRule;
use App\Http\ResponseCodes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class BaseRepository
 * @package App\Repositories\Base
 */
abstract class BaseRepository
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $model;

    /**
     * @var array
     */
    protected static $scopes = [];

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function getById($id)
    {
        $this->checkId($id);
        return $this->startConditions()->findOrFail($id);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function resolveById($id)
    {
        if ($model = $this->getById($id)) {
            app()->instance($this->getModelClass(), $model);
        }
        return $model;
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Support\Collection
     */
    public function getByIds($id)
    {
        if ($this->validateInteger($id)) {
            return $this->startConditions()->ofId($id);
        }
        return collect([]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function getByIdWithoutScopes($id)
    {
        $this->checkId($id);
        return $this->startConditions()->withoutGlobalScopes($this->getScopes())->findOrFail($id);
    }

    /**
     * @param $id
     *
     * @return false
     */
    public function existsId($id)
    {
        if ($this->validateInteger($id)) {
            return $this->getByIds($id)->exists();
        }
        return false;
    }

    /**
     * @param $id
     *
     * @return false
     */
    public function existsIdWithoutScope($id)
    {
        if ($this->validateInteger($id)) {
            return $this->getByIds($id)->withoutGlobalScopes($this->getScopes())->exists();
        }
        return false;
    }

    /**
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * @return mixed
     */
    protected function startConditions()
    {
        return clone $this->model::query();
    }

    /**
     * @return array|null
     */
    public function getScopes()
    {
        return static::$scopes ?: null;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    private function checkId($id)
    {
        if (!$this->validateInteger($id)) {
            throw new HttpException(ResponseCodes::NOT_FOUND);
        }

        return true;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    protected function validateInteger($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => ['required', new SearchValidateIntegerRule()]
        ]);

        return !$validator->fails();
    }
}
