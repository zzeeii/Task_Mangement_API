<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Allow only admins and managers to update tasks
        return in_array($this->user()->role, ['admin', 'manager']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|nullable|string|max:255',
            'description' => 'sometimes|nullable|string',
            'priority' => 'sometimes|nullable|in:low,medium,high',
            'due_date' => 'sometimes|nullable|date_format:Y-m-d H:i',
            'status' => 'sometimes|nullable|in:pending,in-progress,completed',
            'created_by'=>'sometimes|nullable|',
        ];
    }
  
}
