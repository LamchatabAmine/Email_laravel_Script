<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

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
    /*
    public function handle()
    {
        $smtpServers = json_decode(Storage::get('public/smtp_servers.json'), true);
        $emailAddresses = json_decode(Storage::get('public/email_addresses.json'), true);

        $batchSize = count($emailAddresses);
        $smtpCount = count($smtpServers);

        // Get the current batch index from batch_index.json
        $batchIndexData = json_decode(Storage::get('public/batch_index.json'), true);
        $batchIndex = $batchIndexData['batchIndex'] ?? 0;


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
            batchIndex : $batchIndex

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



            // Increment batch index
            $batchIndex++;

            // Update batch index in batch_index.json
            Storage::put('public/batch_index.json', json_encode(['batchIndex' => $batchIndex]));


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
    */

    public function handle()
    {
        $smtpServers = json_decode(Storage::get('public/smtp_servers.json'), true);
        $emailAddresses = json_decode(Storage::get('public/email_addresses.json'), true);

        $batchSize = count($emailAddresses);
        $smtpCount = count($smtpServers);

        // Get the current batch index from batch_index.json
        $batchIndexData = json_decode(Storage::get('public/batch_index.json'), true);
        $batchIndex = $batchIndexData['batchIndex'] ?? 0;

        // Initialize counters for statistics
        $successCount = 0;
        $failureCount = 0;

        // Loop through email addresses
        foreach ($emailAddresses as $item) {
            $smtpIndex = $batchIndex % $smtpCount;
            $smtp = $smtpServers[$smtpIndex];

            $BusinessName = $item['title'];
            $BestEmail = $item['bestEmail'];

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



            // Construct email content
            $emailContent = "Hello {$BusinessName},\n\n";

            $emailContent .= "https://www.youtube.com/watch?v=4j8aNFrp7Eg";

            $emailContent .= "\n
    🌟 Unlock Your {$BusinessName}'s Hidden Potential with GeoPath Navigator! 🌐✨

    Are you ready to usher in the success of 2024? Say hello to GeoPath Navigator by Nety Services—the ultimate solution to transform mundane directions into an unforgettable visual journey!

    🚀 New Year, New Visibility! Exclusive Limited-Time Offer for 2024! 🎉

    Celebrate the arrival of 2024 with a bang! For a limited time, enjoy an unprecedented 80% OFF on our premium GeoPath Navigator service. Only $40, and you'll receive a stunning 30fps video that not only showcases your {$BusinessName}'s location but turns every arrival into a memorable experience. Upgrade to an immersive 60fps video for just $50!

    🌐 Seamless Navigation, Captivating Experience: Say goodbye to lost clients and hello to a guided journey! Our GeoPath Navigator seamlessly directs your potential customers from familiar landmarks to your {$BusinessName}'s doorstep. Watch as your location transforms into a captivating visual story, ensuring an unforgettable first impression.

    🎁 Why Choose GeoPath Navigator by Nety Services?

    ✨ Precision in Every Pixel: Immerse your clients in an unrivaled visual experience. Our high-quality videos guide them seamlessly from nearby landmarks to your {$BusinessName}'s business, ensuring they arrive effortlessly.

    💼 Tailored Branding: Put your {$BusinessName} in the spotlight with personalized branding. GeoPath Navigator lets you showcase your uniqueness, making a lasting impression on every viewer.

    🌍 Global Reach, Local Charm: Whether you're a local gem or a global brand, GeoPath Navigator ensures that your clients not only find {$BusinessName} but fall in love with its location.

    📺 Unleash the Power of 4K Video Quality: Elevate your visual storytelling with our optional 4K video upgrade! Immerse your audience in stunning, crystal-clear detail, bringing {$BusinessName}'s location to life like never before.

    🔮 From Map Points to Masterpieces - GeoPath Navigator Lights the Way! Transform {$BusinessName}'s business journey from simple map points to visual masterpieces. Let GeoPath Navigator illuminate the path to its success!

    🚀 It's Time to Win the Competition with Professional Video! Stand out in the crowd and surpass your competition with our professional video service. GeoPath Navigator allows you to share your visually stunning video across platforms and captivate clients like never before.

    🎉 New Year 2024 Exclusive: Act Fast to Secure Your Discount! To celebrate the arrival of 2024, we're extending this exclusive offer. 

    Get GeoPath Navigator for only $40 (30fps) or elevate your experience with an immersive 60fps video for just $50! A remarkable 80% OFF! This limited-time deal ends on 03/03/2024.
    
    🕛 Act Fast - Offer Ends Soon!

    This exclusive New Year offer is valid only until 03/03/2024. Don't miss your chance to transform {$BusinessName}'s business visibility and leave a lasting impression on its clients.

    ✨ Ready to Transform Your {$BusinessName}'s Journey in 2024? Click 'Get GeoPath Now' and Unlock Your Visual Advantage! 🚀

    👉 Get GeoPath Now - $40 (30fps) or $50 (60fps) Only! 🎉

    GeoPath Navigator - Where {$BusinessName}'s Success Begins!
    \n\n";



            $emailContent .= "https://services.nety.ma/geopath-navigator/";

            $emailContent .= "\n\nRegards,\nNety";

            // Generate a random tag
            $randomTag = Str::random(12);
            $emailContent .= "\n\n: $randomTag";

            $subject = "Unlock Your {$BusinessName}'s Potential with GeoPath Navigator - Limited Time Offer Inside!";

            try {
                // Send email
                Mail::raw($emailContent, function ($message) use ($smtp, $BestEmail, $subject) {
                    $message->from($smtp['from'])->to($BestEmail)->subject($subject);
                });
                $successCount++;
            } catch (\Exception $e) {
                Log::error('Failed to send email: ' . $e->getMessage());
                $failureCount++;
            }

            // Increment batch index
            $batchIndex++;

            // Update batch index in batch_index.json
            Storage::put('public/batch_index.json', json_encode(['batchIndex' => $batchIndex]));

            // Check if it's time to wait before sending the next batch of emails
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
