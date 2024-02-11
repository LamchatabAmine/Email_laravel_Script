<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $smtpServers = json_decode(Storage::get('public/smtp_servers.json'), true);
        $emailAddresses = json_decode(Storage::get('public/email_addresses.json'), true);

        $batchSize = count($emailAddresses);
        $smtpCount = count($smtpServers);
        $batchIndex = 0;


        // this is for statistics

        $successCount = 0;
        $failureCount = 0;
        $totalDeliveryTime = 0;

        // this is for statistics



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

            $text = <<<EOT
            Hello,

            This is a test email message sent using Scheduler.

            SMTP Index: $smtpIndex

            Regards,
            Nety
            EOT;

            // Generate a random tag
            $randomTag = Str::random(12); // Adjust the length as needed

            $text .= "\n\n: $randomTag";


            try {
                Mail::raw($text, function ($message) use ($email, $smtp) {
                    $message->from($smtp['from'])->to($email)->subject('Test Email');
                });
                $successCount++;
            } catch (\Exception $e) {
                Log::error('Failed to send email: ' . $e->getMessage());
                $failureCount++;
            }


            $batchIndex++;

            if ($batchIndex % $batchSize === 0) {
                Log::info('Waiting for 5 minutes before sending the next batch of emails.');
                sleep(300); // 5 minutes delay
            }
        }


        // Calculate statistics
        $totalCount = $successCount + $failureCount;
        $successRate = $totalCount > 0 ? ($successCount / $totalCount) * 100 : 0;
        $failureRate = $totalCount > 0 ? ($failureCount / $totalCount) * 100 : 0;

        // Log statistics
        Log::info('Success Rate: ' . $successRate . '%');
        Log::info('Failure Rate: ' . $failureRate . '%');

    }
}
