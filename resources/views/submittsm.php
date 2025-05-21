<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\TSMNote;
 
class SubmitTSMNotesController extends Controller
{
    public function submitTSMNotes(Request $request)
    {
        // Define the storage paths for the upload and final folders
        $uploadPath = 'C:/TSMNotes/storage/app/tsm-notes-upload/';
        $finalPath = 'C:/TSMNotes/storage/app/tsm-notes-final/';
   
        try {
            // Ensure directories exist
            foreach ([$uploadPath, $finalPath] as $path) {
                if (!file_exists($path) && !mkdir($path, 0777, true)) {
                    throw new \Exception('Failed to create directory: ' . $path);
                }
            }
   
            // Validate file existence in request
            $files = $request->file('files');
            if (!$files) {
                throw new \Exception('No files were uploaded.');
            }                                                                                                              
   
            // Normalize single file to array
            $files = is_array($files) ? $files : [$files];
   
            foreach ($files as $file) {
                // Generate unique filename
                $timestamp = round(microtime(true) * 1000);
                $randomStr = bin2hex(random_bytes(4));
                $filename = "tsm_job_note-{$timestamp}-{$randomStr}.csv";
                $destination = $uploadPath . $filename;
   
                // Move uploaded file
                if (!$file->move($uploadPath, $filename)) {
                    throw new \Exception('File move failed: ' . $filename);
                }
   
                // Process file
                $file_data = fopen($destination, 'r');
                if (!$file_data) {
                    throw new \Exception('Failed to open uploaded file: ' . $filename);
                }
   
                // Create final file
                $finalFile = $finalPath . $filename;
                $open = fopen($finalFile, 'w');
                if (!$open) {
                    throw new \Exception('Failed to open final file for writing: ' . $filename);
                }
   
                // Write header
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
                        if (!fputcsv($open, [$row[0], $row[1], 'UNKNOWN_USER'])) {
                            throw new \Exception('Failed to write data to final file: ' . $filename);
                        }
   
                        // Store metadata in DB
                        TSMNote::create([
                            'job_number' => $row[0],
                            'notes' => $row[1],
                            'user' => 'UNKNOWN_USER',
                            'file_path' => $finalFile,
                            'processed_at' => now(),
                        ]);
                    } else {
                        error_log('Invalid row format or empty row detected.');
                    }
                }
   
                // Prepare email with attachment
                $file_attach = file_get_contents($finalFile);
                if ($file_attach === false) {
                    throw new \Exception('Failed to read final file: ' . $filename);
                }
                $base64string = base64_encode($file_attach);
                $accessToken = $this->getToken();
                if (!$accessToken) {
                    throw new \Exception('Failed to retrieve access token.');
                }
   
                $emailPayload = [
                    "message" => [
                        //"subject" => "XML:JOB NOTE",
                        "subject" => "XML:JOB NOTE TEST",
                        "body" => ["contentType" => "Text", "content" => "This is an automated email. Please do not reply."],
                        "toRecipients" => [["emailAddress" => ["address" => "tsmxml@globalfoodequipment.com.au"]]],
                        "attachments" => [[
                            "@odata.type" => "#microsoft.graph.fileAttachment",
                            "name" => $filename,
                            "contentType" => "text/plain",
                            "contentBytes" => $base64string
                        ]]
                    ]
                ];
   
                // Send email
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
            }
        } catch (\Exception $e) {
            \Log::error('Error in submitTSMNotes: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
   
        return response()->json(['success' => 'TSM Notes submitted successfully!']);
    }
   
 
    public function getToken()
    {
        // OAuth2 Token URL and other necessary details
        $tenant = '68981705-98d9-44f3-a72b-61c7cd3ef4fd'; // Update with your tenant ID
        $tokenUrl = 'https://login.microsoftonline.com/' . $tenant . '/oauth2/v2.0/token';
        $clientId = 'fa2fb323-21d0-4967-abe7-585013608b13'; // Update with your Client ID
        $clientSecret = 'h2b8Q~ztG8BG0EPZxTbJd7L_5VkM65ItwgfFodsD'; // Update with your Client Secret
        $scope = 'https://graph.microsoft.com/.default'; // Scope for Microsoft Graph API access
 
        // Prepare the POST data for the OAuth2 token request
        $postData = [
            'grant_type' => 'client_credentials',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'scope' => $scope
        ];
 
        // Initialize cURL
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
 
        // Execute the request and handle the response
        $response = curl_exec($curl);
       
        if (curl_errno($curl)) {
            // Handle cURL error
            error_log('cURL error: ' . curl_error($curl));
            return null; // Return null on error
        }
 
        // Close cURL session
        curl_close($curl);
 
        // Decode the JSON response to extract the access token
        $responseData = json_decode($response, true);
 
        if (isset($responseData['access_token'])) {
            return $responseData['access_token']; // Return the access token if found
        } else {
            // Handle case where access token is not returned
            error_log('Error: ' . $responseData['error_description'] ?? 'Unknown error');
            return null;
        }
    }
}