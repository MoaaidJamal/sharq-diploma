<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class OrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $title_ar;
    private $title_en;
    private $type;
    private $order_id;
    public function __construct($title_ar, $title_en, $type, $order_id = null)
    {
        $this->title_ar = $title_ar;
        $this->title_en = $title_en;
        $this->type = $type;
        $this->order_id = $order_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class, 'database'];
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()->setTitle('Breathe With Us')->setBody($this->{'title_'.locale()}))
            ->setData([
                'title_ar' => 'تنفس معنا',
                'title_en' => 'Breathe With Us',
                'body_ar' => $this->title_ar,
                'body_en' => $this->title_en,
                'type' => ''.$this->type,
                'order_id' => ''.$this->order_id,
            ])
            ->setAndroid(AndroidConfig::create()->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))->setNotification(AndroidNotification::create()->setColor('#0A0A0A')))
            ->setApns(ApnsConfig::create()->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }

    public function toDatabase($notifiable)
    {
        $data = [
            'title_ar' => $this->title_ar,
            'title_en' => $this->title_en,
            'type' => $this->type,
            'order_id' => $this->order_id,
        ];
        return $data;
    }
}
