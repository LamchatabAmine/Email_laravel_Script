<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class SmtpController extends Controller
{
    public function addSmtp(Request $request)
    {
        $data = Validator::make($request->all(), [
            'host' => 'required|string',
            'port' => 'required|integer',
            'username' => 'required|string',
            'password' => 'required|string',
            'from' => 'required|email',
        ]);

        if ($data->fails()) {
            return response()->json(['message' => 'Invalid file format or size'], 400);
        }

        // Check if the file exists
        $filePath = 'public/smtp_servers.json';
        if (Storage::exists($filePath)) {
            // File exists, so we'll append the new SMTP data
            $existingData = json_decode(Storage::get($filePath), true);
            $existingData[] = $data;
            Storage::put($filePath, json_encode($existingData));
        } else {
            // File doesn't exist, create a new one with the SMTP data
            Storage::put($filePath, json_encode([$data]));
        }

        return response()->json(['message' => 'SMTP added successfully']);
    }
}
