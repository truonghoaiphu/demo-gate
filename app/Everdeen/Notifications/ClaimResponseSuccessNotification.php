<?php

namespace Katniss\Everdeen\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Mail\BaseMailable;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Models\ClaimRequest;
use Katniss\Everdeen\Models\ClaimResponse;
use Katniss\Everdeen\Utils\Settings;

class ClaimResponseSuccessNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $claimRequest;
    protected $claimResponse;
    protected $settings;

    public function __construct(User $user, ClaimRequest $claimRequest, ClaimResponse $claimResponse, Settings $settings)
    {
        $this->user = $user;
        $this->claimRequest = $claimRequest;
        $this->claimResponse = $claimResponse;
        $this->settings = $settings;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        
        return new BaseMailable('claim_response_success', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->display_name,
            BaseMailable::EMAIL_SUBJECT => trans('label.email_matching_request_success_inform', [
                'learnerName' => $this->claimRequest->name,
                'requestId' => $this->claimRequest->id
            ]),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'email' => $this->user->email,
            'shown_name' => $this->user->shown_name,
            'claim_request' => $this->claimRequest,
            'carer' => $this->claimRequest->carer,
        ], currentLocaleCode());
    }
}