<?php

namespace App\Enums\ResponseStatuses;

enum GlobalStatusCodesEnum: int
{
    case Success = 200;
    case Error = 100;
    case ValidationError = 422;
    case ServerError = 500;
}
