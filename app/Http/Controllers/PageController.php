<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\PageUrl;

class PageController extends Controller
{
    /**
     * @param PageUrl $page
     * @return array
     */
    public function show(PageUrl $page): array
    {
        return ResponseHelper::successBody($page->load('domain')->toArray());
    }
}
