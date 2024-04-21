<?php

namespace App\Helpers;

use App\Enums\ResponseStatuses\GlobalStatusCodesEnum;
use UnitEnum;

class ResponseHelper
{
    /**
     * @param array|string $data - in array case parameter will be data, in string case parameter will be a message
     * @param string $message
     * @param UnitEnum|int $statusCode
     * @return array
     */
    public static function successBody(
        array|string $data,
        string $message = '',
        UnitEnum|int $statusCode = GlobalStatusCodesEnum::Success
    ): array
    {
        $message = is_string($data) && trim($message) === '' ? $data : $message;
        $data = is_array($data) ? $data : [];

        return [
            'status'     => true,
            'statusCode' => is_numeric($statusCode) ? $statusCode : $statusCode->value,
            'message'    => $message,
            'data'       => $data,
        ];
    }

    /**
     * @param string $message
     * @param UnitEnum|int $statusCode
     * @return array
     */
    public static function failureBody(
        string $message = '',
        UnitEnum|int $statusCode = GlobalStatusCodesEnum::Error
    ): array
    {
        return [
            'status'     => false,
            'statusCode' => is_numeric($statusCode) ? $statusCode : $statusCode->value,
            'message'    => $message,
        ];
    }
}
