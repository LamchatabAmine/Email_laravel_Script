<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmailStatisticsController extends Controller
{
    public function index()
    {
        // Retrieve email addresses and SMTP servers
        $emailAddresses = json_decode(Storage::get('public/email_addresses.json'), true);
        $smtpServers = json_decode(Storage::get('public/smtp_servers.json'), true);

        // Count the number of email addresses and SMTP servers
        $emailCount = count($emailAddresses);
        $smtpCount = count($smtpServers);

        // Pass the counts to the view
        return view('welcome', compact('emailCount', 'smtpCount'));
    }
}
