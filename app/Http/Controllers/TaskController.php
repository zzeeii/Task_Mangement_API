<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\AssignTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of tasks.
     */
    public function index(Request $request)
    {
        $tasks = $this->taskService->getTasks($request->priority, $request->status);
        return response()->json($tasks);
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->createTask($request->validated());
        return response()->json($task, 201);
    }

    /**
     * Display the specified task.
     */
    public function show($id)
    {   
        $task=Task::find($id);
        $task->load('user');
        return response()->json($task);
    }

    /**
     * Update the specified task in storage.
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->taskService->updateTask($id, $request->validated());
        return response()->json($task);
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy($id)
    {  
        $this->taskService->deleteTask($id);
        return response()->json(null, 204);
    }

    /**
     * Assign a task to a user.
     */
    public function assign(AssignTaskRequest $request, $id)
    { 
        
        $task = $this->taskService->assignTask($id, $request->validated()['assigned_to']);
        return response()->json($task);
    }

    /**
     * Update the status of a task.
     */
    public function updateStatus(UpdateTaskStatusRequest $request, $id)
    {
        $task = $this->taskService->updateTaskStatus($id, $request->validated()['status']);
        return response()->json($task);
    }
}

