<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TSMNote extends Model
{
    use HasFactory;

    protected $table = 'tsm_notes';

    protected $fillable = [
        'job_number',
        'notes',
        'user',
        'file_path',
        'processed_at',
    ];

    // Your other model methods here

    /**
     * Store uploaded file and return the stored path.
     *
     * @param  mixed $file
     * @return string
     */
    public function userInfo()
    {
        return $this->belongsTo(User::class, 'user', 'tsm_employee_code');
    }


    public static function storeFile($file)
    {
        $milliseconds = round(microtime(true) * 1000);
        $filename = $milliseconds . '.csv';
        $destination = "uploads/tsm-notes-upload/" . $filename;
        
        move_uploaded_file($file, $destination);
        
        return $destination;
    }

    /**
     * Process CSV file and store the parsed data.
     *
     * @param  string $filePath
     * @return string
     */
    public static function processCSV($filePath)
    {
        $milliseconds = round(microtime(true) * 1000);
        $filename_new = 'tsm_job_note-' . $milliseconds . '.csv';
        $finalPath = "uploads/tsm-notes-final/" . $filename_new;

        $file_data = fopen($filePath, 'r');
        $open = fopen($finalPath, 'w');

        fputcsv($open, ['JOB NUMBER', 'NOTES', 'USER']);
        
        $firstIterationSkipped = false;
        while ($row = fgetcsv($file_data)) {
            if (!$firstIterationSkipped) {
                $firstIterationSkipped = true;
                continue;
            }
            fputcsv($open, [$row[0], $row[1], 'UNKNOWN_USER']);
        }
        fclose($open);

        return $finalPath;
    }
}

