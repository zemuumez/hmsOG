<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'template_name' => EmailTemplate::APPOINTMENT_REMINDER_DOCTOR,
                'email_subject' => 'Appointment Reminder - Doctor',
                'email_content' => "
                    <p>Dear Dr. {{doctor_name}},</p>
                    <br>
                    <p>This is a kind reminder that you have an upcoming appointment scheduled with {{patient_name}} within the next hour.</p>
                    <br>

                    <p><strong>Patient Concern:</strong> {{problem}}<br>
                    <strong>Scheduled Time:</strong> {{appointment_date}}</p>

                    <br>
                    <p>Kindly be prepared and available to attend the appointment on time.</p>

                    <p>Thank you for your continued care and support.</p>

                    <br>
                    <p>Regards,<br>
                    {{app_name}}</p>
                ",
                'dynamic_variables' => json_encode([
                    'doctor_name',
                    'patient_name',
                    'problem',
                    'appointment_date',
                    'app_name',
                ]),
            ],

            [
                'template_name' => EmailTemplate::APPOINTMENT_REMINDER_PATIENT,
                'email_subject' => 'Appointment Reminder To Patient',
                'email_content' => "
                    <p>Dear {{patient_name}},</p>
                    <br>

                    <p>We hope you are doing well.</p>

                    <p>This is a friendly reminder that your appointment with Dr. {{doctor_name}} is scheduled within the next hour.</p>
                    <br>
                    <p><strong>Concern:</strong>  {{problem}}<br>
                    <strong>Appointment Time:</strong>  {{appointment_date}}</p>

                    <p>Please ensure that you are available at the scheduled time. If you need any assistance or wish to reschedule, feel free to contact us.</p>

                    <p>We look forward to serving you.</p>

                    <br>
                    <p>Regards,<br>
                    {{app_name}}</p>
                ",
                'dynamic_variables' => json_encode([
                    'patient_name',
                    'doctor_name',
                    'problem',
                    'appointment_date',
                    'app_name',
                ]),
            ],

            [
                'template_name' => EmailTemplate::FORGOT_PASSWORD,
                'email_subject' => 'Reset Your Password',
                'email_content' => "
                    <p>Hello, {{full_name}}</p>
                    <br>
                    <p>We have received a request to reset the password associated with your account.</p>

                    <p>Please use the link below to securely reset your password:</p>

                    <br>
                    <p style='text-align:center; margin: 20px 0;'><a href='{{link}}'>Reset Password</a></p>
                    <br>

                    <p>For security reasons, this link will expire in 60 minutes.</p>

                    <p>If you did not request a password reset, please ignore this email. No further action is required.</p>

                    <br>
                    <p>Regards,<br>
                    {{app_name}}</p>
                ",
                'dynamic_variables' => json_encode([
                    'full_name',
                    'link',
                    'app_name',
                ]),
            ],

            [
                'template_name' => EmailTemplate::HOSPITAL_ENQUIRY,
                'email_subject' => 'New Hospital Enquiry',
                'email_content' => "
                    <p>Hello {{admin_name}},</p>
                    <br>

                    <p>A new enquiry has been received through the hospital enquiry system.</p>
                    <br>

                    <p><strong>Name:</strong> {{full_name}}</p>
                    <p><strong>Purpose:</strong> {{purpose}}</p>
                    <p><strong>Phone:</strong> {{contact_no}}</p>
                    <p><strong>Email:</strong> {{email}}</p>
                    <p><strong>Message:</strong> {{message}}</p>

                    <br>
                    <p>Please review the details and respond at your earliest convenience.</p>

                    <br>
                    <p>Regards,</p>
                    <p>{{app_name}}</p>
                ",
                'dynamic_variables' => json_encode([
                    'admin_name',
                    'full_name',
                    'purpose',
                    'contact_no',
                    'email',
                    'message',
                    'app_name',
                ]),
            ],

            [
                'template_name' => EmailTemplate::EMAIL_VERIFICATION,
                'email_subject' => 'Verify Your Email',
                'email_content' => "
                    <p>Hello {{full_name}},</p>
                    <br>
                    <p>Thank you for registering with {{app_name}}.</p>
                    <p>Please click the button below to verify your email address:</p>
                    <br>
                     <p style='text-align:center; margin: 20px 0;'><a href='{{link}}'>Verify Email</a></p>
                    <br>
                    <p>This link will expire in 60 minutes.</p>
                    <br>
                    <p>Regards,<br>
                    {{app_name}}</p>
                ",
                'dynamic_variables' => json_encode([
                    'full_name',
                    'link',
                    'app_name',
                ]),
            ],
        ];

        foreach ($templates as $template) {
            DB::table('email_templates')->updateOrInsert(
                ['template_name' => $template['template_name']],
                [
                    'email_subject' => $template['email_subject'],
                    'email_content' => $template['email_content'],
                    'dynamic_variables' => $template['dynamic_variables'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
