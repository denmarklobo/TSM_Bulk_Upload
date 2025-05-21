<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Models\AdminLog;
use App\Models\AdminLogin;

class AuthController extends Controller
{

        public function getAllUsers()
    {
        // Fetch all users
        $users = User::all();
        
        // Return a success response with the list of users
        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => $users,
        ], 200);
    }
    
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // First, try to authenticate as admin
        $admin = AdminLogin::where('email', $request->email)->first();

        if ($admin) {
            // Check password
            if (!Hash::check($request->password, $admin->password)) {
                return response()->json(['message' => 'Incorrect password. Please try again.'], 401);
            }

            // Redirect admins to /admin
            return response()->json([
                'message' => 'Login successful',
                'role' => 'admin',
                'redirect_to' => '/admin',
                'email' => $admin->email,
                'name' => $admin->name ?? null
            ], 200);
        }

        // If not admin, try to authenticate as user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'The email address is not registered.'], 404);
        }

        // Check if account is suspended
        if ($user->status !== 1) {
            return response()->json(['message' => 'Your account has been suspended.'], 403);
        }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Incorrect password. Please try again.'], 401);
        }

        // Create token for user
        $token = $user->createToken('API Token')->plainTextToken;

        // Redirect users to /upload
        return response()->json([
            'message' => 'Login successful',
            'role' => 'user',
            'token' => $token,
            'redirect_to' => '/upload',
            'tsm_employee_code' => $user->tsm_employee_code,
            'email' => $user->email,
            'name' => $user->name
        ], 200);
    }

    public function logout(Request $request)
{
    try {
        // If using Laravel Sanctum or Passport
        $user = Auth::user();

        if ($user && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete(); // For Sanctum
        }

        return response()->json([
            'message' => 'Logged out successfully.'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to log out.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function adminLogout(Request $request)
{
    try {
        // Use custom guard 'adminlogin' to get the admin user
        $admin = Auth::guard('adminlogin')->user();

        if ($admin && $request->user('adminlogin')->currentAccessToken()) {
            $request->user('adminlogin')->currentAccessToken()->delete(); // For Sanctum
        }

        return response()->json([
            'message' => 'Admin logged out successfully.'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to log out.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'tsm_employee_code' => 'required|string|unique:users,tsm_employee_code',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'The name is required.',
            'tsm_employee_code.required' => 'The TSM employee code is required.',
            'tsm_employee_code.unique' => 'The TSM employee code has already been taken.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);
    
        // If validation fails, return validation errors
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
    
        // Create a new user if validation passes
        $user = new User();
        $user->name = $request->name;
        $user->tsm_employee_code = $request->tsm_employee_code;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);  // Hash the password before storing
        $user->save();
    
        // Create a token for the newly registered user
        $token = $user->createToken('API Token')->plainTextToken;
    
        // Return a success response with token
        return response()->json([
            'message' => 'Registration successful',
            'token' => $token,
        ]);
}

public function suspend($userId)
{
    // Find the user by ID
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Set the status to 0 (suspended)
    $user->status = 0;

    // Log the suspension details
    Log::info('User Suspended', [
        'job_number' => $user->job_number, // You may need to replace with the actual field from User model
        'notes' => 'User suspension initiated', // You can replace this with a dynamic message if needed
        'name' => $user->name,
        'email' => $user->email,
        'file_path' => 'N/A', // You can replace with actual file path if applicable
        'processed_at' => now(),
    ]);

    AdminLog::create([
        'user_id' => $user->id,
        'job_number' => $user->job_number,
        'submitted_by' => $user->name, // Assuming the logged-in user is the one performing the action
        'name' => $user->name,
        'email' => $user->email,
        'action' => 'Suspended',
        'file_path' => 'N/A',  // Adjust if you have a file path
        'processed_at' => now(),
    ]);

    // Save the user changes
    $user->save();

    return response()->json(['message' => 'User suspended successfully'], 200);
}


public function enable($userId)
{
    // Find the user by ID
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Set the status to 1 (enabled)
    $user->status = 1;

    Log::info('User Enable', [
        'job_number' => $user->job_number, // You may need to replace with the actual field from User model
        'notes' => 'User suspension initiated', // You can replace this with a dynamic message if needed
        'name' => $user->name,
        'email' => $user->email,
        'file_path' => 'N/A', // You can replace with actual file path if applicable
        'processed_at' => now(),
    ]);

    AdminLog::create([
        'user_id' => $user->id,
        'job_number' => $user->job_number,
        'submitted_by' => $user->name, // Assuming the logged-in user is the one performing the action
        'name' => $user->name,
        'email' => $user->email,
        'action' => 'Enabled',
        'file_path' => 'N/A',  // Adjust if you have a file path
        'processed_at' => now(),
    ]);


    // Save the changes
    $user->save();

    return response()->json(['message' => 'User enabled successfully'], 200);
}

public function delete($userId)
{
    // Find the user by ID
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Handle related records (example: deleting related TSM notes)
    $user->tsmNotes()->delete();  // Delete related TSM notes (change if you want to archive instead)

    // Log the deletion action
    Log::info('User Delete', [
        'job_number' => $user->job_number, 
        'notes' => 'User removal initiated', 
        'name' => $user->name,
        'email' => $user->email,
        'file_path' => 'N/A', 
        'processed_at' => now(),
    ]);

    // Store the deleted user details in the admin_logs table
    AdminLog::create([
        'user_id' => $user->id,
        'job_number' => $user->job_number,
        'name' => $user->name,
        'email' => $user->email,
        'action' => 'Removed', 
        'file_path' => 'N/A', 
        'processed_at' => now(),
    ]);

    // Perform the deletion
    $user->delete();

    return response()->json(['message' => 'User deleted successfully'], 200);
}


}
