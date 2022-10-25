<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;
use App\Models\User;

class VerifyRegistation extends Notification
{
    use Queueable;

    public $user;
    public $token;
 

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user,$token)
    {
        $this->user = $user;
        $this->token = $token;

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
       return (new MailMessage)
                    ->line('Dear '.$this->user->username)
                    ->line('Your account has been created successfully! Please verify your account to login.')
                    ->action('Click here to verify', route('user.verification', $this->token))
                    ->line('Thank you for using our application!');
    }

    //for sms notification

    // public function toNexmo($notifiable)
    // {
    //     return (new NexmoMessage)
    //         ->content('Dear ' . $this->user->username . 'your account is registered')
    //         ->from($this->user->phoneno);
            
   // }

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
