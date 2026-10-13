<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    private array $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function build(){
        $emailTemplate = EmailTemplate::where('template_name',EmailTemplate::FORGOT_PASSWORD)->first();

        $emailContent = $emailTemplate->renderContent([
            'full_name' => $this->data['full_name'] ?? '',
            'link' => $this->data['link'] ?? '',
            'app_name' => config('app.name'),
        ]);

        return $this->subject($emailTemplate->email_subject)
        ->view('emails.common')
        ->with([
            'data' => $emailContent
        ]);
    }
}
