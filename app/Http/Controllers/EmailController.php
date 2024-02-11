<?php

namespace App\Http\Controllers;

use Config;
use Carbon\Carbon;
use App\Mail\MarketingMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmailController extends Controller
{
    public function sendEmails()
    {
        $smtpServers = json_decode(Storage::get('public/smtp_servers.json'), true);
        $emailAddresses = json_decode(Storage::get('public/email_addresses.json'), true);

        $batchSize = count($emailAddresses);
        $smtpCount = count($smtpServers);
        $batchIndex = 0;



        foreach ($emailAddresses as $email) {

            $smtpIndex = $batchIndex % $smtpCount;

            $smtp = $smtpServers[$smtpIndex];

            $config = [
                'transport' => 'smtp',
                'host' => $smtp['host'],
                'port' => $smtp['port'],
                'from' => $smtp['from'],
                'encryption' => 'tls',
                'username' => $smtp['username'],
                'password' => $smtp['password']
            ];

            // Set the mail configuration dynamically
            Config::set('mail.mailers.smtp', $config);

            // TODO: send with message which smtp send this message
            $text = <<<EOT
            Hello,

            This is a test email message sent using Laravel.

            Regards,
            Nety
            EOT;

            // Generate a random tag
            $randomTag = Str::random(12); // Adjust the length as needed

            $text .= "\n\n: $randomTag";

            Mail::raw($text, function ($message) use ($email, $smtp) {
                $message->from($smtp['from'])->to($email)->subject('Test Email');
            });


            $batchIndex++;

            if ($batchIndex % $batchSize === 0) {
                Log::info('Waiting for 5 minutes before sending the next batch of emails.');
                sleep(300); // 5 minutes delay
            }
        }

        return 'Emails sent successfully!';
    }



    public function test()
    {
        $smtpServers = json_decode(Storage::get('public/smtp_servers.json'), true);
        $emailAddresses = json_decode(Storage::get('public/email_addresses.json'), true);

        // Get the first SMTP server from the configuration
        $smtp = reset($smtpServers);

        $config = [
            'transport' => 'smtp',
            'host' => $smtp['host'],
            'port' => $smtp['port'],
            'from' => $smtp['from'],
            'encryption' => 'tls',
            'username' => $smtp['username'],
            'password' => $smtp['password']
        ];

        // Set the mail configuration dynamically
        Config::set('mail.mailers.smtp', $config);

        // Send email using the configured SMTP server to the first email address
        $email = reset($emailAddresses);

        $text = <<<EOT
            Hello,

            This is a test email message sent using Laravel.

            Regards,
            Nety
            EOT;

        // Generate a random tag
        $randomTag = Str::random(12); // Adjust the length as needed

        $text .= "\n\n: $randomTag";

        Mail::raw($text, function ($message) use ($email, $smtp) {
            $message->from($smtp['from'])->to($email)->subject('Test Email');
        });


        // Send the email using the Markdown template
        // Mail::to($email)->send(new MarketingMail());

        return 'Email sent successfully!';
    }



}

