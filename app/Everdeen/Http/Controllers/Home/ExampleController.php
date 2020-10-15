<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-02-06
 * Time: 16:12
 */

namespace Katniss\Everdeen\Http\Controllers\Home;

use Katniss\Everdeen\Http\Controllers\ViewController;

class ExampleController extends ViewController
{
    public function index()
    {
        return $this->_any('home');
    }
}