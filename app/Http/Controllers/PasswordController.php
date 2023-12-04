<?php

namespace App\Http\Controllers;

use App\Models\Password;
use Illuminate\Http\Request;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Crypt;


class PasswordController extends Controller
{
    public function store(Request $request)
    {
        // Generate or retrieve your custom key
        $hashedKey = hash('sha256', $request->app_key, true);
        $encrypter = new Encrypter($hashedKey, 'AES-256-CBC');


        Password::updateOrCreate(
            ['account_name' => $request->account_name], // Check if a record with this account_name exists
            [
                'username' => $request->username,
                'password' => $encrypter->encrypt($request->password), // Encrypting the password
            ]
        );

        return back()->with('success', 'Password saved successfully');
    }


    public function show(Request $request)
    {
        $passwords = Password::all();
        // Check if the form is being submitted
        if ($request->isMethod('post')) {
            $password = Password::where('account_name', $request->account_name)->firstOrFail();
            $hashedKey = hash('sha256', $request->app_key, true);
            $encrypter = new Encrypter($hashedKey, 'AES-256-CBC');

            try {
                $decryptedPassword = $encrypter->decrypt($password->password);
            } catch (\Exception $e) {
                // Handle decryption errors (e.g., incorrect key)
                return back()->withErrors('Failed to decrypt password. Please check the key.');
            }

            // Return the same view but with the decrypted password
            return view('show', compact('passwords', 'password', 'decryptedPassword'));

        }

        // If it's not a POST request, just show the form
        return view('show', compact('passwords'));
    }
}