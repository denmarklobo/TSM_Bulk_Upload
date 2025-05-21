<?php

namespace App\Http\Controllers;

use App\Models\AdminLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    /**
     * Handle the registration of a new admin user.
     */
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_login,email',
            'password' => 'required|string|min:8|confirmed', // Confirmed means 'password' and 'password_confirmation' fields
        ]);

        // If validation fails, return a response with errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new admin user
        $admin = AdminLogin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password before saving it
        ]);

        // Return a success response with the created user
        return response()->json([
            'message' => 'Admin user registered successfully.',
            'admin' => $admin
        ], 201);
    }

    /**
     * Handle the login of an admin user.
     */
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',    
            'password' => 'required|string',
        ]);
    
        // Retrieve the admin by email
        $admin = AdminLogin::where('email', $request->email)->first();
    
        // Check if the admin exists
        if (!$admin) {
            return response()->json(['message' => 'The email address is not registered.'], 404); // Wrong email
        }
    
        // Check if the password is correct
        if (!Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Incorrect password. Please try again.'], 401); // Wrong password
        }
    
        // Generate the URL for the named route
        $redirectTo = route('admin');  // Generate the URL for the 'admin' route
    
        // Return a success response with the authenticated admin user and the redirect URL
        return response()->json([
            'message' => 'Login successful',
            'admin' => $admin,
            'redirect_to' => $redirectTo,  // Include the redirect URL here
        ], 200);
    }
    
}
