<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Log in the user with the given credentials.
     * 
     * @param array $credentials
     * @return array
     * @throws ValidationException
     */
    public function login(array $credentials)
    {
        try {
            // Attempt to authenticate
            $token = Auth::attempt($credentials);

            if (!$token) {
                throw ValidationException::withMessages(['error' => 'Unauthorized: Invalid credentials']);
            }

            // Retrieve authenticated user
            $user = Auth::user();

            return [
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
            ];
        } catch (Exception $e) {
            // Handle exceptions and throw them back to the controller
            throw new Exception($e->getMessage(), 401);
        }
    }

    /**
     * Register a new user.
     * 
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function register(array $data)
    {
        try {
            // Create the new user
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->role = $data['role']; 
            $user->save(); 
           

            // Log the user in automatically
          // Auth::login($user);

            return [
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user,
                'authorisation' => [
                    'token' =>  Auth::login($user),
                    'type' => 'bearer',
                ],
            ];
        } catch (Exception $e) {
            throw new Exception('Error registering user: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Log out the authenticated user.
     * 
     * @return array
     */
    public function logout()
    {
        Auth::logout();

        return [
            'status' => 'success',
            'message' => 'Successfully logged out',
        ];
    }

    /**
     * Refresh the JWT token for the user.
     * 
     * @return array
     */
    public function refresh()
    {
        return [
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ];
    }
}
