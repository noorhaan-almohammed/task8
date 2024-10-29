<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task = $this->route('task');
        if (auth()->user()->id != $task->owner_id) {
            throw new HttpResponseException(
                response()->json(['message' => 'You are not authorized to update this task.'], 403)
            );
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|max:255',
            'description' => 'nullable|max:255',
            'due_date' => 'nullable|date|after:now',
         ];
    }
}
