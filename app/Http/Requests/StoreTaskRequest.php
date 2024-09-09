<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Allow only admins and managers to create tasks
        return in_array($this->user()->role, ['admin', 'manager']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date_format:d-m-Y H:i',
            'status' => 'required|in:pending,in-progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
            'created_by'=>'sometimes|required'
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'created_by' => Auth::id(), 
        ]);
    }
}
