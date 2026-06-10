<?php
// app/Notifications/HospitalDisqualified.php

namespace App\Notifications;

use App\Models\Hospital;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HospitalDisqualified extends Notification
{
    use Queueable;

    public function __construct(
        public Hospital $hospital,
        public array    $reasons,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('NCEEIC Solarisation Grant — Pre-eligibility Result')
            ->greeting('Dear ' . $this->hospital->hospital_name . ',')
            ->line('Thank you for your interest in the NCEEIC Hospital Solarisation Grant Programme.')
            ->line('After reviewing your pre-eligibility information, we regret to inform you that your hospital does not currently meet the minimum eligibility criteria for the programme.')
            ->line('**Reasons for ineligibility:**');
            foreach ($this->reasons as $reason) {
                $mail->line('• ' . $reason);
            }

        $mail
            ->line('**Minimum requirements for eligibility:**')
            ->line('• A minimum of **50 beds**')
            ->line('• At least **20%** of revenue from health insurance')
            ->line('If you believe this assessment is incorrect, or if your hospital\'s situation changes in the future, please do not hesitate to contact us for a manual review.')
            ->action('Contact NCEEIC Grants Team', 'mailto:grants@nceeic.org')
            ->line('We encourage you to reapply in a future cycle once your hospital meets the criteria.')
            ->salutation('Regards, NCEEIC Grants Team | grants@nceeic.org | +234 809 101 0103');

        return $mail;
    }
}
