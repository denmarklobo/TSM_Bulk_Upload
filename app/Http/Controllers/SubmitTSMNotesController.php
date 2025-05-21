<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TSMNote;
use App\Models\ActivityLog;

class SubmitTSMNotesController extends Controller
{

    private function logUserActivity($tsmUser, $Name, $email, $fileName, $action, $status)
    {
        ActivityLog::create([
            'user' => $tsmUser,
            'name' => $Name,
            'email' => $email,
            'file_name' => $fileName,
            'action' => $action,
            'status' => $status,
        ]);
    }

    public function tsmNotes()
    {
        try {
            $tsmNotes = TSMNote::with('userInfo')->get();
    
            $formatted = $tsmNotes->map(function ($note) {
                return [
                    'job_number' => $note->job_number,
                    'submitted_by' => $note->user,
                    'name' => optional($note->userInfo)->name,
                    'email' => optional($note->userInfo)->email,    
                    'file_path' => $note->file_path,
                    'processed_at' => $note->processed_at,
                    'action' => 'Upload',
                    'status' => $note->processed_at ? 'Success' : 'Failed',  // Conditional status field
                ];
            });
    
            return response()->json($formatted);
        } catch (\Exception $e) {
            \Log::error('Error in fetchAllTSMNotesWithUsers: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch TSM Notes'], 500);
        }
    }

    public function submitTSMNotes(Request $request)
    {
        $uploadPath = 'tsm-notes-upload/';
        $finalPath = 'tsm-notes-final/';
        $tsmUser = $request->input('tsm_employee_code', 'UNKNOWN_USER');
    
        try {
            foreach ([$uploadPath, $finalPath] as $path) {
                if (!file_exists(storage_path('app/' . $path)) && !mkdir(storage_path('app/' . $path), 0777, true)) {
                    throw new \Exception('Failed to create directory: ' . $path);
                }
            }
    
            $files = $request->file('files');
            if (!$files) {
                throw new \Exception('No files were uploaded.');
            }
    
            $files = is_array($files) ? $files : [$files];
    
            foreach ($files as $file) {
                $timestamp = round(microtime(true) * 1000);
                $filename = "tsm_job_note-{$timestamp}.csv";
                $destination = storage_path('app/' . $uploadPath . $filename);
    
                if (!$file->storeAs($uploadPath, $filename)) {
                    throw new \Exception('File move failed: ' . $filename);
                }
    
                $file_data = fopen($destination, 'r');
                if (!$file_data) {
                    throw new \Exception('Failed to open uploaded file: ' . $filename);
                }

                $finalFile = storage_path('app/' . $finalPath . $filename);
                $open = fopen($finalFile, 'w');
                if (!$open) {
                    throw new \Exception('Failed to open final file for writing: ' . $filename);
                }
    
                if (!fputcsv($open, ['JOB NUMBER', 'NOTES', 'USER'])) {
                    throw new \Exception('Failed to write header to final file: ' . $filename);
                }
    
                $firstIterationSkipped = false;
                while ($row = fgetcsv($file_data)) {
                    if (!$firstIterationSkipped) {
                        $firstIterationSkipped = true;
                        continue;
                    }
    
                    if (is_array($row) && count($row) >= 2) {
                        if (!fputcsv($open, [$row[0], $row[1], $tsmUser])) {
                            throw new \Exception('Failed to write data to final file: ' . $filename);
                        }
    
                        TSMNote::create([
                            'job_number' => $row[0],
                            'notes' => $row[1],
                            'user' => $tsmUser,
                            'file_path' => $finalFile,
                            'processed_at' => now(),
                        ]);
                    } else {
                        error_log('Invalid row format or empty row detected.');
                    }
                }
    
                fclose($open);
                fclose($file_data);
    
                $file_attach = file_get_contents($finalFile);
                if ($file_attach === false) {
                    throw new \Exception('Failed to read final file: ' . $filename);
                }
    
                $base64string = base64_encode($file_attach);
                $accessToken = $this->getToken();
    
                $emailPayload = [
                    "message" => [
                        "subject" => "XML:JOB NOTE TEST",
                        "body" => ["contentType" => "Text", "content" => "This is an automated email. Please do not reply."],
                        "toRecipients" => [["emailAddress" => ["address" => "tsmxml@globalfoodequipment.com.au"]]],
                        "attachments" => [[
                            "@odata.type" => "#microsoft.graph.fileAttachment",
                            "name" => $filename,
                            "contentType" => "text/csv",
                            "contentBytes" => $base64string
                        ]]
                    ]
                ];
    
                $curl = curl_init("https://graph.microsoft.com/v1.0/users/automations@dunbraegroup.onmicrosoft.com/sendMail");
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($emailPayload),
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $accessToken,
                    ],
                ]);
    
                $response = curl_exec($curl);
                if (curl_errno($curl)) {
                    throw new \Exception('Curl error: ' . curl_error($curl));
                }
                curl_close($curl);
    
                $this->logUserActivity(
                    $tsmUser,
                    $request->input('name', 'UNKNOWN_NAME'),
                    $request->input('email', 'UNKNOWN_EMAIL'),
                    $filename,
                    'Upload',
                    'Success'
                );
            }
    
        } catch (\Exception $e) {
            $this->logUserActivity(
                $tsmUser ?? 'UNKNOWN_TSM_USER',
                $request->input('name', 'UNKNOWN_NAME'),
                $request->input('email', 'UNKNOWN_EMAIL'),
                'N/A',
                'Upload',
                'Failed'
            );
    
            \Log::error('Error in submitTSMNotes: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    
        return response()->json(['success' => 'TSM Notes submitted successfully!']);
    }

    public function getToken()
    {

    
        $postData = [
            'grant_type' => 'client_credentials',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'scope' => $scope
        ];
    
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => $tokenUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postData),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
            ],
        ]);
    
        $response = curl_exec($curl);
    
        if (curl_errno($curl)) {
            error_log('cURL error: ' . curl_error($curl));
            return null;
        }
    
        curl_close($curl);
    
        error_log('Token Response: ' . $response);
    
        $responseData = json_decode($response, true);
    
        if (isset($responseData['access_token'])) {
            return $responseData['access_token'];
        } else {
            error_log('Error: ' . ($responseData['error_description'] ?? 'Unknown error'));
            return null;
        }
    }
}
