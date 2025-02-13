<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;

class CustomVerifyEmail extends BaseVerifyEmail
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Custom Verification Email Subject')
                    ->line('Thank you for registering!')
                    ->line('Please click the button below to verify your email address.')
                    ->action('Verify Email Address', $this->verificationUrl($notifiable))
                    ->line('If you did not register for an account, no further action is required.')
                    ->salutation('Regards, Your App Team');
    }
}
