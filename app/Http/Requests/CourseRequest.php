<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // You can add authorization logic here if needed
        return true; // Or false, depending on your authorization rules
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'course_name' => 'required|string|max:255',
            'start_day' => 'required|date',
            'end_day' => 'required|date|after_or_equal:start_day',
            'status' => 'required|in:0,1',
            'default_deadline' => 'nullable|date_format:H:i:s',
            'course_deadline' => 'nullable|date_format:Y-m-d H:i:s',
            'class_id' => 'required|integer|exists:classes,id',
            'teacher_id' => 'required|integer|exists:teachers,id',
        ];
    }
}
