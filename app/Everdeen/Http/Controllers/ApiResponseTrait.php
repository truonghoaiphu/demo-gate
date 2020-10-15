<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-08-26
 * Time: 20:22
 */

namespace Katniss\Everdeen\Http\Controllers;


trait ApiResponseTrait
{
    protected static $extraResponse = [
        '_block' => null,
    ];

    public static function addBlockResponseMessage($message, $fresh = false)
    {
        if ($fresh || self::$extraResponse['_block'] == null) {
            self::$extraResponse['_block'] = [];
        }
        self::$extraResponse['_block'][] = $message;
    }

    protected function response($failed, $data = null, $message = '')
    {
        return response()->json([
            '_success' => !$failed,
            '_messages' => empty($message) ? null : (array)$message,
            '_data' => $data,
        ]);
    }

    protected function responseSuccess($data = null)
    {
        return $this->response(false, $data);
    }

    protected function responseFail($message = '', $data = null)
    {
        return $this->response(true, $data, $message);
    }
}