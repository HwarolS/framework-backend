<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class prueba extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        // // Asunto del correo
        // $this->subject('Correo de prueba');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Asunto del correo
        $this->subject('Correo de prueba');
        return $this->view('view.name');
    }
}