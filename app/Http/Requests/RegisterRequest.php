<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * Only admins should be able to make the registration request.
     * 
     * @return bool
     */
    public function authorize()
    {
        // Only allow the request if the user is an admin
        return Auth::check() && Auth::user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,manager,user',
        ];
    }

    /**
     * Customize the response for failed authorization.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    protected function failedAuthorization()
    {
        // Return an unauthorized response
        abort(response()->json([
            'status' => 'error',
            'message' => 'Unauthorized: Only admins can register new users',
        ], 403));
    }
}
