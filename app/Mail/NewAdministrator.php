<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAdministrator extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var $administrator
     */
    public $administrator;

    /**
     * NewAdministrator constructor.
     * @param $data
     */
    public function __construct($data) {
        $this->administrator = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('STUP - Dados de acesso')
            ->markdown('emails.administrator.new');

    }
}
