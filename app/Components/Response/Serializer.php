<?php

namespace App\Components\Response;

use App\Components\Paginate\OffsetPaginator;
use App\Interfaces\Base\Arrayable;
use App\Interfaces\Base\ResponsePaginationInterface;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Class Serializer
 * @package App\Components\Response
 */
class Serializer implements \App\Interfaces\Base\Serializer
{
    use HasEvents;

    public $fieldsParam = 'fields';
    public $expandParam = 'expand';
    public $totalCountHeader = 'X-Pagination-Total-Count';
    public $pageCountHeader = 'X-Pagination-Page-Count';
    public $currentPageHeader = 'X-Pagination-Current-Page';
    public $perPageHeader = 'X-Pagination-Per-Page';

    private $headers = [];

    /**
     * @return array[]
     */
    public function getRequestedFields()
    {
        $fields = request()->get($this->fieldsParam);
        $expand = request()->get($this->expandParam);

        return [
            is_string($fields) ? preg_split('/\s*,\s*/', $fields, -1, PREG_SPLIT_NO_EMPTY) : [],
            is_string($expand) ? preg_split('/\s*,\s*/', $expand, -1, PREG_SPLIT_NO_EMPTY) : [],
        ];
    }

    /**
     * @return array
     */
    public function getFields()
    {
        [$fields, $expand] = $this->getRequestedFields();

        return [
            $this->fieldsParam => $fields,
            $this->expandParam => $expand
        ];
    }

    /**
     * @return array
     */
    public function getExpandFields()
    {
        return \Arr::get($this->getFields(), $this->expandParam);
    }

    /**
     * @param $data
     *
     * @return array|LengthAwarePaginator
     */
    public function serialize($data)
    {
        if ($data instanceof Collection) {
            return $this->serializeModels($data);
        } elseif ($data instanceof LengthAwarePaginator || $data instanceof ResponsePaginationInterface) {

            /**
             * @var $data LengthAwarePaginator
             */
            $this->addHeader($this->totalCountHeader, $data->total());
            $this->addHeader($this->pageCountHeader, $data->lastPage());
            $this->addHeader($this->currentPageHeader, $data->currentPage());
            $this->addHeader($this->perPageHeader, $data->perPage());

            if (request()->isMethod('HEAD')) {
                return [];
            }
            return $this->serializeModels($data->items());
        } elseif ($data instanceof Model) {
            return $this->serializeModel($data);
        } elseif ($data instanceof OffsetPaginator) {
            $this->addHeader($this->totalCountHeader, $data->total());
            return $this->serializeModels($data->items());
        }

        return $data;
    }

    /**
     * @param array $models
     *
     * @return array
     */
    protected function serializeModels($models)
    {
        foreach ($models as $i => $model) {
            $models[$i] = $this->serializeModel($model);
        }

        return $models;
    }

    /**
     * @param $model
     *
     * @return array
     */
    protected function serializeModel($model)
    {
        if ($model instanceof Arrayable) {
            [$fields, $expand] = $this->getRequestedFields();

            /**
             * @var $model Arrayable
             */
            return $model->generateArray($fields, $expand);
        } elseif ($model instanceof Model) {
            return $model->toArray();
        }

        return $model;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }


    /**
     * @param $key
     * @param $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }
}
