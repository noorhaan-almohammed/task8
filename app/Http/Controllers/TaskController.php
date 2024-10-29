<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Services\TaskService;
use App\Http\Resources\TaskResource;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateStatusTaskRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService){
       $this->taskService = $taskService;  // inject taskService to the controller
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = $this->taskService->listTask();
        if($tasks->isEmpty()){
            return response()->json(['message' => 'No tasks were added.']);
        }
       

        return parent::successResponse('Tasks',TaskResource::collection($tasks),'Tasks retrived Successfully',200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $taskData = $request->validated();
        $task = $this->taskService->createTask($taskData);
        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
        // return parent::successResponse('Task',new TaskResource($task),'Task Created Successfully',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return parent::successResponse('Task',new TaskResource($task),'Task retrived Successfully',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $taskData = $request->validated();
        $task = $this->taskService->updateTask($taskData,$task);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
        // return parent::successResponse('Task',new TaskResource($task),'Task Updated Successfully',201);
    }
    public function updateStatus(UpdateStatusTaskRequest $request, Task $task)
    {
        $taskData = $request->validated();
        $task = $this->taskService->updateStatus($taskData,$task);
        return parent::successResponse('Task',new TaskResource($task),'Task Status Updated Successfully',201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $Task)
    {
        $this->taskService->deleteTask($Task);
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');

        // return parent::successResponse('data',null, "Task Deleted Successfully",200);
    }

    /**
     * Display a paginated listing of the trashed (soft deleted) resources.
     */
    public function trashed(Request $request)
    {
        $trashedTasks = $this->taskService->trashedListTask();
        return parent::successResponse('Tasks',TaskResource::collection($trashedTasks),'Tasks retrived Successfully',200);
    }

    /**
     * Restore a trashed (soft deleted) resource by its ID.
     */
    public function restore($id)
    {
        $Task = $this->taskService->restoreTask($id);
        return parent::successResponse('Task',new TaskResource($Task),'Task restored Successfully',200);
    }

    /**
     * Permanently delete a trashed (soft deleted) resource by its ID.
     */
    public function forceDelete($id)
    {
        $this->taskService->forceDeleteTask($id);
        return parent::successResponse('data',null, "Task Deleted Permanently",200);
    }
}
