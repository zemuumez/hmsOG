<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailTemplate;
use App\Models\User;

class AppointmentReminderDoctorMail extends Mailable
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
        $emailTemplate = EmailTemplate::where(
            'template_name',
            EmailTemplate::APPOINTMENT_REMINDER_DOCTOR
        )->first();

        $emailContent = $emailTemplate->renderContent([
            'doctor_name' => $this->data['doctor_name'] ?? '',
            'patient_name' => $this->data['patient_name'] ?? '',
            'problem' => $this->data['problem'] ?? '',
            'appointment_date' => $this->data['appointment_date'] ?? '',
            'app_name' => config('app.name'),
        ]);

        return $this->subject($emailTemplate->email_subject)
        ->view('emails.common')
        ->with([
            'data' => $emailContent
        ]);
    }
}
