<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentReminderPatientMail extends Mailable
{
    use Queueable, SerializesModels;

    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function build()
    {
        $emailTemplate = EmailTemplate::where('template_name',EmailTemplate::APPOINTMENT_REMINDER_PATIENT)->first();

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
