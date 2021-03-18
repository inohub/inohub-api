<?php


namespace App\Http;


class ResponseCodes
{
    const SUCCESS           = 200;
    const CREATED           = 201;
    const BAD_REQUEST       = 400;
    const UNAUTHORIZED      = 401;
    const FORBIDDEN         = 403;
    const NOT_FOUND         = 404;
    const VALIDATION_ERROR  = 418;
    const WRONG_DATA        = 406;
    const FAILED_RESULT     = 417;
    const UNPROCESSABLE     = 422;
}
