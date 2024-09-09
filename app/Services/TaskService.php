<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Exception;

class TaskService
{
    /**
     * Get a list of tasks, optionally filtered by priority and status.
     *
     * @param string|null $priority
     * @param string|null $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTasks($priority = null, $status = null)
    {
        try {
            return Task::query()
                ->with('user')
                ->when($priority, fn($query) => $query->priority($priority))
                ->when($status, fn($query) => $query->status($status))
                ->get();
        } catch (Exception $e) {
            throw new Exception('Failed to fetch tasks: ' . $e->getMessage());
        }
    }

    /**
     * Create a new task. Only admin or manager can create tasks.
     *
     * @param array $data
     * @return Task
     * @throws AuthorizationException
     */
    public function createTask(array $data)
    {
        if (!in_array(Auth::user()->role, ['admin', 'manager'])) {
            throw new AuthorizationException('Unauthorized to create tasks.');
        }

        try {
            return Task::create($data);
        } catch (Exception $e) {
            throw new Exception('Failed to create task: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing task. Only admin or manager can update tasks.
     *
     * @param Task $task
     * @param array $data
     * @return Task
     * @throws AuthorizationException
     */
    public function updateTask($task_id, array $data)
    {
        if (!in_array(Auth::user()->role, ['admin', 'manager'])) {
            throw new AuthorizationException('Unauthorized to update tasks.');
        }

        try {
            $task=Task::find($task_id);
            $task->update($data);
            return $task;
        } catch (Exception $e) {
            throw new Exception('Failed to update task: ' . $e->getMessage());
        }
    }

    /**
     * Delete a task. Only admin can delete tasks.
     *
     * @param Task $task
     * @throws AuthorizationException
     */
    public function deleteTask($id)
    {   $task=Task::find($id);
        $user = Auth::user();

        // Check if the user is admin or the manager who created the task
        if ($user->role === 'admin' || ($user->role === 'manager' && $task->created_by == $user->id)) {
            try {
                $task->delete();
            } catch (Exception $e) {
                throw new Exception('Failed to delete task: ' . $e->getMessage());
            }
        } else {
            throw new AuthorizationException('Unauthorized to delete this task.');
        }
    
    }

    /**
     * Assign a task to a user. Only admin or manager can assign tasks.
     *
     * @param Task $task
     * @param int $userId
     * @return Task
     * @throws AuthorizationException
     */
    public function assignTask($task_id, int $userId)
    { 
        if (!in_array(Auth::user()->role, ['admin', 'manager'])) {
            throw new AuthorizationException('Unauthorized to assign tasks.');
        }

        try {
            $task=Task::find($task_id);
           
            $task->update(['assigned_to' => $userId]);
            return $task;
        } catch (Exception $e) {
            throw new Exception('Failed to assign task: ' . $e->getMessage());
        }
    }

    /**
     * Update the status of a task. Only assigned user or admin can update the status.
     *
     * @param Task $task
     * @param string $status
     * @return Task
     * @throws AuthorizationException
     */
    public function updateTaskStatus($id, string $status)
    { 
        echo $id;
        $task=Task::find($id);
        echo $task;
        if (Auth::user()->id !== $task->assigned_to || Auth::user()->role !== 'admin') {
            throw new AuthorizationException('Unauthorized to update task status.');
        }

        try {
            $task->update(['status' => $status]);
            return $task;
        } catch (Exception $e) {
            throw new Exception('Failed to update task status: ' . $e->getMessage());
        }
    }
}
