<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class HospitalEnquiryMail extends Mailable
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
        $emailTemplate = EmailTemplate::where('template_name',EmailTemplate::HOSPITAL_ENQUIRY)->first();
        $adminUser = User::orderBy('created_at')->first();

        $emailContent = $emailTemplate->renderContent([
            'admin_name' => $adminUser?->full_name ?? 'Admin',
            'full_name' => $this->data['full_name'] ?? '',
            'purpose' => $this->data['purpose'] ?? '',
            'contact_no' => $this->data['contact_no'] ?? '',
            'message' => $this->data['message'] ?? '',
            'email' => $this->data['email'] ?? '',
            'app_name' => config('app.name'),
        ]);

        return $this->subject($emailTemplate->email_subject)
        ->view('emails.common')
        ->with([
            'data' => $emailContent
        ]);
    }
 
}
