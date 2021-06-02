<?php

namespace App\StartupStatus;

/**
 * Class StartupStatus
 * @package App\StartupStatus
 */
class StartupStatus
{
    const DRAFT   = 1;
    const PUBLISH = 2;
    const APPROVE = 3;
    const ARCHIVE = 4;
    const BLOCK   = 5;

    /**
     * @return int[]
     */
    public static function getList()
    {
        return [
            self::DRAFT,
            self::PUBLISH,
            self::APPROVE,
            self::ARCHIVE,
            self::BLOCK,
        ];
    }

    /**
     * @return array[]
     */
    public static function getDescription()
    {
        return [
            [
                'value' => self::DRAFT,
                'name'  => 'Черновик',
            ],
            [
                'value' => self::PUBLISH,
                'name'  => 'Опубликован',
            ],
            [
                'value' => self::APPROVE,
                'name'  => 'Одобрен',
            ],
            [
                'value' => self::ARCHIVE,
                'name'  => 'Архивирован',
            ],
            [
                'value' => self::BLOCK,
                'name'  => 'Заблокирован',
            ]
        ];
    }
}
