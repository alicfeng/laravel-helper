<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Service;

use AlicFeng\Helper\Helper\ResponseHelper;

/**
 * Service Base Class
 * All Service Class Extends This For Unit Result
 * Class BaseService.
 */
class BaseHelperService
{
    /**
     * @var ResponseHelper
     */
    public $rspHelper;

    public function __construct()
    {
        $this->rspHelper = app()->make(ResponseHelper::class);
    }
}
