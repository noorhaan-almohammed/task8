<?php
namespace App\Http\Services;

use Exception;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TaskService
{
    public function createTask(array $fieldInputs)
    {

        try {
        $task = Task::create([
            'title' => $fieldInputs['title'],
            'description' => $fieldInputs['description'],
            'status_id' => $fieldInputs['status'],
            'due_date' => $fieldInputs['due_date'],
            'owner_id' => auth()->user()->id,
            ]);
       return $task;
        } catch (Exception $e) {
            Log::error('Error creating Task: ' . $e->getMessage());
            throw new HttpResponseException(response()->json('there is something wrong in server',500), );
        }
    }

    public function updateTask($taskData,$task){
        try{
           $data = [
                'title' => $taskData['title'] ?? $task->title,
                'description' => $taskData['description'] ?? $task->description,
                'due_date' => $taskData['due_date'] ?? $task->due_date,
           ];
           $task->update($data);
           return $task;
        }
        catch(HttpException $e){
            Log::error('Error updating Task: ' . $e->getMessage());
            throw new HttpResponseException(response()->json('You are not authorized to update this task.',403), );
        }
        catch (Exception $e) {
            Log::error('Error updating Task: ' . $e->getMessage());
            throw new HttpResponseException(response()->json('there is something wrong in server',500), );
        }
    }
    public function updateStatus($data,$task){
         $task->status_id = $data['status_id'] ?? $task->status_id;
         $task->save();
         return $task;
    }
    public function listTask(){
        try{
            $tasks = Cache::remember('tasks', 60, function() {
                return Auth::user()->tasks;
            });
            return $tasks;
        }
        catch (Exception $e) {
            Log::error('Error retriving Task: ' . $e->getMessage());
            throw new HttpResponseException(response()->json('there is something wrong in server',500), );
        }

    }

    /**
     * Delete a specific Task.
     *
     * @param Task $Task
     * @return void
     */
    public function deleteTask($Task)
    {
        try {
            $Task->delete();
        } catch (ModelNotFoundException $e) {
            Log::error('Error finding Task: ' . $e->getMessage());
            throw new HttpResponseException(response()->json('Task not found',404), );
        } catch (Exception $e) {
            Log::error('Error deleting Task: ' . $e->getMessage());
            throw new HttpResponseException(response()->json('there is something wrong in server',500), );
        }
    }

    /**
     * Display a paginated listing of the trashed (soft deleted) resources.
     */
    public function trashedListTask()
    {
        try {
            return Task::onlyTrashed()->simplePaginate(10);
        } catch (Exception $e) {
            Log::error('Error trashed List Task: ' . $e->getMessage());
            throw new HttpResponseException(response()->json('there is something wrong in server',500), );
        }
    }

    /**
     * Restore a trashed (soft deleted) resource by its ID.
     *
     * @param  int  $id  The ID of the trashed Task to be restored.
     * @return \App\Models\Task
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the Task with the given ID is not found.
     * @throws \Exception If there is an error during the restore process.
     */
    public function restoreTask($id)
    {
        try {
            $Task = Task::onlyTrashed()->findOrFail($id);
            $Task->restore();
            return $Task;
        } catch (ModelNotFoundException $e) {
            Log::error('Error finding Task: ' . $e->getMessage());
            throw new HttpResponseException(response()->json('Task not found',404), );
        } catch (Exception $e) {
            Log::error('Error restoring Task: ' . $e->getMessage());
            throw new HttpResponseException(response()->json('there is something wrong in server',500), );
        }
    }

    /**
     * Permanently delete a trashed (soft deleted) resource by its ID.
     *
     * @param  int  $id  The ID of the trashed Task to be permanently deleted.
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the Task with the given ID is not found.
     * @throws \Exception If there is an error during the force delete process.
     */
    public function forceDeleteTask($id)
    {
        try {
            $trashedTask = Task::onlyTrashed()->findOrFail($id);
            if(auth()->id() !== $trashedTask->created_by){
                throw new HttpResponseException(response()->json(['message' => 'You can not delete this task, You\'re not creator!'],403), );
            }
            // dd($trashedTask);
            $trashedTask->forceDelete();
        // } catch (QueryException $e) {
        //         Log::error('Error Task: ' . $e->getMessage());
        //         throw new HttpResponseException(response()->json('Task depends on another task',409), );

        } catch (ModelNotFoundException $e) {
            Log::error('Error finding Task: ' . $e->getMessage());
            throw new HttpResponseException(response()->json(['message' => 'Task not found'],404), );
        }
         catch (Exception $e) {
            Log::error('Error restoring Task: ' . $e->getMessage());
            throw new HttpResponseException(response()->json('there is something wrong in server',500), );
        }
    }
}
