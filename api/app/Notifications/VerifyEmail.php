<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\InteractsWithTime;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable,
        InteractsWithTime;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // TODO: refactor url generation
        $url = config('app.frontend_url') . '/register/verification/' . ($notifiable->emailVerificationSignatureParameters())['hash'] . '?expires=' . strtotime(now()->addHours(1)) . '&id=' . $notifiable->id . '&email=' . rawurlencode($notifiable->getEmailForVerification());
        
        return (new MailMessage)
            ->subject('Verify Your Account | Story Share')
            ->markdown('mail.email_verification', [
                // 'url' => sprintf('%s&email=%s', $this->verificationUrl($notifiable), rawurlencode($notifiable->getEmailForVerification())),
                'url' => $url,
                'newEmail' => $notifiable->getEmailForVerification() == $notifiable->new_email
            ]);
    }
}
