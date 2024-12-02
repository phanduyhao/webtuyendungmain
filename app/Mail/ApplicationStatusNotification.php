<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $status;

    /**
     * Create a new message instance.
     *
     * @param  Application  $application
     * @param  string  $status
     * @return void
     */
    public function __construct(Application $application, $status)
    {
        $this->application = $application;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $statusMessage = $this->status == 1 ? 'đã được duyệt' : 'đã bị từ chối';

        return $this->subject('Thông báo về trạng thái đơn ứng tuyển')
                    ->view('email.mail_application') // Chỉ định view email
                    ->with([
                        'company' => $this->application->Job->company->name,
                        'jobTitle' => $this->application->Job->title,
                        'statusMessage' => $statusMessage,
                    ]);
    }
}
