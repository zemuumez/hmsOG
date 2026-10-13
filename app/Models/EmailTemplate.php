<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    public $fillable = ['template_name','email_subject','email_content','dynamic_variables'];

    protected $casts = [
        'dynamic_variables' => 'array',
    ];

    public const APPOINTMENT_REMINDER_DOCTOR = 'Appointment Reminder To Doctor';

    public const APPOINTMENT_REMINDER_PATIENT = 'Appointment Reminder To Patient';

    public const APPOINTMENT_REMINDER = 'Appointment Reminder';

    public const FORGOT_PASSWORD = 'Forgot Password';

    public const HOSPITAL_ENQUIRY = 'Hospital Enquiry';

    public const EMAIL_VERIFICATION = 'Email Verification';

    public function renderContent(array $replacements = []): string
    {
        $content = (string) $this->email_content;

        foreach ($replacements as $variable => $value) {
            $pattern = '/{{\s*' . preg_quote(trim((string) $variable), '/') . '\s*}}/';
            $content = preg_replace($pattern, (string) $value, $content);
        }

        return $content;
    }
}
