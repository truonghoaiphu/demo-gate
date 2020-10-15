<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2018-08-15
 * Time: 11:04
 */

namespace Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Notifications\Channels;


use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Vendors\Edujugon\PushNotification\PushNotification;

class IosChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $deviceTokens = $this->getDeviceTokens($notifiable, $notification);
        if (count($deviceTokens) > 0) {
            $push = new PushNotification('apn');
            return $push->setMessage($this->getMessage($notifiable, $notification))
                ->setDevicesToken($deviceTokens)
                ->send()
                ->getFeedback();
        }

        return false;
    }

    /**
     * Get the data for the notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return array
     *
     * @throws \RuntimeException
     */
    protected function getMessage($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toIos')) {
            return $notification->toIos($notifiable);
        }

        throw new \RuntimeException('Notification is missing toIos method.');
    }

    /**
     * Get the data for the notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return array
     *
     * @throws \RuntimeException
     */
    protected function getDeviceTokens($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'getIosDeviceTokens')) {
            return $notification->getIosDeviceTokens($notifiable);
        }

        throw new \RuntimeException('Notification is missing getIosDeviceTokens method.');
    }
}