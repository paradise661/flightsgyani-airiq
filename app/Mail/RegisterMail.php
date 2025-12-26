<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Auth\Notifications\VerifyEmail; // Add this

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $verificationUrl;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;

        // Generate the verification URL
        $this->verificationUrl = $this->generateVerificationUrl($user);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Register Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        // Pass the user and the verification URL to the email view
        return new Content(
            view: 'emails.verifyemail',
            with: [
                'user' => $this->user,
                'verificationUrl' => $this->verificationUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    /**
     * Generate the email verification URL.
     *
     * @param  \App\Models\User  $user
     * @return string
     */
    private function generateVerificationUrl($user)
    {
        // Generate the verification URL (this assumes the default verification route)
        // return route('verification.verify', [
        //     'id' => $user->getKey(),
        //     'hash' => sha1($user->getEmailForVerification())
        // ]);

        $userId = $user->getKey(); // User's ID
        $verificationCode = sha1($user->getEmailForVerification()); // Hash of the email
        $expiresTimestamp = now()->addMinutes(config('auth.verification.expire', 60))->timestamp; // Expiry timestamp
        $signature = hash_hmac('sha256', $userId . $verificationCode . $expiresTimestamp, config('app.key')); // Signature

        // Return the URL
        return url("/email/verify/{$userId}/{$verificationCode}?expires={$expiresTimestamp}&signature={$signature}");
    }
}
