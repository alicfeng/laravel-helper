<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Controller;

use AlicFeng\Helper\Service\CryptHelperService;
use Illuminate\Http\Request;

/**
 * Class HelperController.
 */
class CryptController extends BaseHelperController
{
    private $_cryptService;

    /**
     * HelperController constructor.
     */
    public function __construct(CryptHelperService $cryptService)
    {
        $this->_cryptService = $cryptService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('helper.decrypt');
    }

    /**
     * @return string
     */
    public function decrypt(Request $request)
    {
        $message = $this->safeFilter($request->get('content'));

        return $this->_cryptService->decrypt($message);
    }
}
