<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TaskStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:2000',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:todo,in_progress,blocked,in_review,completed',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 2000 characters.',
            'description.string' => 'The description must be a string.',
            'status.in' => 'The status field must be from todo,in_progress,blocked,in_review,completed.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 422,
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 422));
    }
}
