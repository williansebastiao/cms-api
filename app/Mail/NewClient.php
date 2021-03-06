<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewClient extends Mailable {

    use Queueable, SerializesModels;

    /**
     * @var $client
     */
    public $client;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data) {
        $this->client = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('CMS - Dados de acesso')
            ->markdown('emails.client.new');
    }
}
