<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function getAllActivityLogs()
    {
        $logs = ActivityLog::all();
        return response()->json($logs);
    }
}
