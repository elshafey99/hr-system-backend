<?php

namespace App\Notifications;

use App\Models\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpNotification extends Notification
{
    use Queueable;

    protected $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct(Otp $otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $purposeText = $this->otp->purpose === 'password_reset' 
            ? 'Password Reset' 
            : 'Phone Verification';

        return (new MailMessage)
            ->subject('Your OTP Code - ' . $purposeText)
            ->greeting('Hello ' . $notifiable->full_name . '!')
            ->line('Your OTP code for ' . strtolower($purposeText) . ' is:')
            ->line('**' . $this->otp->code . '**')
            ->line('This code will expire in 5 minutes.')
            ->line('If you did not request this code, please ignore this email.');
    }
}
