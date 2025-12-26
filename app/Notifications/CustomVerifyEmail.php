<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class CustomVerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

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
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Please verify your email address')
            ->view('emails.verifyemail', [
                'name' => $notifiable->name,
                'verification_url' => $url,
            ]);
    }

    /**
     * Generate the verification URL with custom expiration.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        // Calculate expiration time (example: 60 minutes from now)
        $expires = Carbon::now()->addMinutes(60)->timestamp;

        // Generate the verification URL with expiration using Laravel's signed route
        $url = URL::temporarySignedRoute(
            'user.verification.verify',
            now()->addMinutes(60), // Set the expiration for the URL
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );

        // Append the custom `expires` parameter (not the signature)
        // $url .= '&expires=' . $expires;

        // Return the URL with expires, but without adding the signature manually
        return $url;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
