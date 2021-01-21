<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUser extends Mailable {

    use Queueable, SerializesModels;

    /**
     * @var $user
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data) {
        $this->user = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('CMS - Dados de acesso')
            ->markdown('emails.user.new');
    }
}
