<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class GetParameterHandle
 * @package App\Http\Middleware
 */
class GetParameterHandle
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('get')) {
            $request->request->replace($this->parseParameters($request->post()));
        }

        return $next($request);
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    private function parseParameters(array $parameters)
    {
        $fields = Arr::get($parameters, 'fields', []);
        $search = Arr::get($parameters, 'search', []);

        $fields = $this->fieldsParse($fields, array_keys(Arr::get($parameters, 'sort', [])));
        $fields = $this->fieldsParse($fields, array_keys($search));

        return [
            'fields'   => $fields,
            'sort'     => Arr::get($parameters, 'sort', []),
            'search'   => $this->searchParse($search),
            'count'    => Arr::get($parameters, 'count', []),
            'relation' => $this->relationsParse(Arr::get($parameters, 'relation', [])),
        ];
    }

    /**
     * @param array $fields
     * @param array $addedFields
     *
     * @return array
     */
    private function fieldsParse(array $fields, array $addedFields)
    {
        if (count($fields)) {
            $fields[] = 'id';
            $fields = array_unique(array_merge($fields, $addedFields));
        }

        return $fields;
    }

    /**
     * @param array $search
     *
     * @return array
     */
    private function searchParse(array $search)
    {
        $result = [];

        foreach ($search as $key => $value) {

            $exploded = explode('|', $value);

            $value = [
                'operator' => array_first($exploded),
                'value'    => array_last($exploded),
            ];

            switch ($value['operator']) {
                case 'like':
                    $value['value'] = '%' . $value['value'] . '%';
                    break;
                case 'exact':
                    $value['value'] = explode(',', $value['value']);
            }

            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * @param array $relations
     *
     * @return array
     */
    private function relationsParse(array $relations)
    {
        $result = [];

        foreach ($relations as $key => $value) {
            if (!is_array($value)) {
                $result[$key] = [];
                break;
            }

            $result[$key] = [
                'fields' => $this->fieldsParse(Arr::get($value, 'fields', []), array_keys(Arr::get($value, 'search', []))),
                'search' => $this->searchParse(Arr::get($value, 'search', [])),
            ];
        }

        return $result;
    }
}
