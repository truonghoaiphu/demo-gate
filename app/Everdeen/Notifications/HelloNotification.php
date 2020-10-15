<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-05-30
 * Time: 16:43
 */

namespace Katniss\Everdeen\Notifications;

class HelloNotification extends SimpleNotification
{
    public function __construct($message = 'hello')
    {
        parent::__construct(empty($message) ? 'hello' : $message);
    }
}