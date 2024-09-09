<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Allow only admins and managers to assign tasks
        return in_array($this->user()->role, ['admin', 'manager']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'assigned_to' => 'required|exists:users,id',
        ];
    }
}
