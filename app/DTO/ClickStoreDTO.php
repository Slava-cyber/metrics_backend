<?php

namespace App\DTO;

use App\Models\Domain;

class ClickStoreDTO
{
    /**
     * @param Domain $domain
     * @param string $pageUrl
     * @param int $positionX
     * @param int $positionY
     * @param int $screenSizeX
     * @param int $screenSizeY
     * @param string $datetime
     * @param string $timeZone
     * @param string $ip
     */
    public function __construct(
        public readonly Domain $domain,
        public readonly string $pageUrl,
        public readonly int    $positionX,
        public readonly int    $positionY,
        public readonly int    $screenSizeX,
        public readonly int    $screenSizeY,
        public readonly string $datetime,
        public readonly string $timeZone,
        public readonly string $ip
    )
    {
    }
}
