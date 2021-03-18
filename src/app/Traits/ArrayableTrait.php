<?php

namespace App\Traits;

use App\Helpers\DateFormatHelper;
use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * Trait ArrayableTrait
 * @package App\Traits
 */
trait ArrayableTrait
{
    protected static $fields;
    protected static $extraFields;
    protected $fields_appends = [];

    /**
     * @return array|\ArrayAccess|mixed
     */
    public static function getFields()
    {
        return Arr::get(static::$fields, get_called_class(), []);
    }

    /**
     * @return array|\ArrayAccess|mixed
     */
    public static function getExtraFields()
    {
        return Arr::get(static::$extraFields, get_called_class(), []);
    }

    /**
     * @return array|\ArrayAccess|mixed
     */
    public function fields()
    {
        if ([] !== static::getFields()) {
            return static::getFields();
        }

        $attributes = array_keys($this->attributes);
        if (property_exists($this, 'fields_hidden')) {
            $hidden = $this->fields_hidden;
            $filtered = array_filter(
                $this->attributes,
                function ($key) use ($hidden) {
                    return !in_array($key, $hidden);
                },
                ARRAY_FILTER_USE_KEY
            );
            $attributes = array_keys($filtered);
        }

        return array_merge($attributes, $this->fields_appends);
    }

    /**
     * @return array|\ArrayAccess|mixed
     */
    public function extraFields()
    {
        if (null !== static::getExtraFields()) {
            return static::getExtraFields();
        }

        return [];
    }

    /**
     * @param $fields
     */
    public static function setFields($fields)
    {
        static::$fields[get_called_class()] = $fields;
    }

    /**
     * @param $fields
     */
    public static function setExtraFields($fields)
    {
        static::$extraFields[get_called_class()] = $fields;
    }

    /**
     * @param array $fields
     * @param array $expand
     *
     * @return array
     */
    public function generateArray(array $fields = [], array $expand = [])
    {
        $data = [];

        foreach ($this->resolveFields($fields, $expand) as $field => $definition) {
            $value = is_string($definition) ? $this->$definition : call_user_func($definition, $this, $field);
            if ($value instanceof Carbon) {
                if ($this->hasCast($definition) && $this->isCustomDateTimeCast($this->getCasts()[$definition])) {
                    $value = $value->format(explode(':', $this->getCasts()[$definition], 2)[1]);
                } else {
                    $value = $value->format(DateFormatHelper::DATETIME_FORMAT);
                }
            }
            $data[$field] = $value;

        }

        return $data;
    }

    /**
     * @param array $fields
     * @param array $expand
     *
     * @return array
     */
    protected function resolveFields(array $fields, array $expand)
    {
        $result = [];

        foreach ($this->fields() as $field => $definition) {
            if (is_int($field)) {
                $field = $definition;
            }
            if (empty($fields) || in_array($field, $fields, true)) {
                $result[$field] = $definition;
            }
        }

        if (empty($expand)) {
            return $result;
        }

        foreach ($this->extraFields() as $field => $definition) {
            if (is_int($field)) {
                $field = $definition;
            }
            if (in_array($field, $expand, true)) {
                $result[$field] = $definition;
            }
        }

        return $result;
    }

    public static function resetAllFields()
    {
        self::$extraFields = [];
        self::$fields = [];
    }
}
