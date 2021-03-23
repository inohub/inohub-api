<?php

namespace App\ResponseCodes;

/**
 * Class ResponseCodes
 * @package App\Http
 */
class ResponseCodes
{
    const SUCCESS          = 200;
    const CREATED          = 201;
    const BAD_REQUEST      = 400;
    const UNAUTHORIZED     = 401;
    const FORBIDDEN        = 403;
    const NOT_FOUND        = 404;
    const VALIDATION_ERROR = 418;
    const WRONG_DATA       = 406;
    const FAILED_RESULT    = 417;
    const UNPROCESSABLE    = 422;

    /**
     * @return string[]
     */
    public static function getMessage()
    {
        return [
            self::SUCCESS          => 'OK',
            self::CREATED          => 'Created',
            self::BAD_REQUEST      => 'Bad request',
            self::UNAUTHORIZED     => 'Unauthorized',
            self::FORBIDDEN        => 'Forbidden',
            self::NOT_FOUND        => 'Not found',
            self::VALIDATION_ERROR => 'Validation error',
            self::WRONG_DATA       => 'Wrong data',
            self::FAILED_RESULT    => 'Failed result',
            self::UNPROCESSABLE    => 'Unprocessable',
        ];
    }
}
