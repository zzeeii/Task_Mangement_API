<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        $taskId = $this->route('id');
        $task = Task::find($taskId);
        if (!$task) {
            return false;
        }
        

        // Allow only the assigned user or admin to update the task status
        return $this->user()->id === $task->assigned_to || $this->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'status' => 'required|in:pending,in-progress,completed',
        ];
    }
}
