<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewEmployeeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;

    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    /**
     * Create a new message instance.
     */
    // public function __construct()
    // {
    //     //
    // }
    public function build()
    {
        return $this->view('project_manager.add_employee.emails')
            ->with(['employee' => $this->employee]);
    }
}
