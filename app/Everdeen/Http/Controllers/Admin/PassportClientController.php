<?php

namespace Katniss\Everdeen\Http\Controllers\Admin;

use Katniss\Everdeen\Http\Request;

class PassportClientController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->viewPath = 'passport_client';
    }

    public function index(Request $request)
    {
        $this->_title(trans('pages.admin_passport_client_title'));
        $this->_description(trans('pages.admin_passport_client_desc'));

        return $this->_view();
    }
}
