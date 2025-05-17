<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseGoalRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust authorization logic as needed
    }

    public function rules()
    {
        return [
            'course_student_id' => 'required|integer|exists:course_students,id',
            'message_id' => 'nullable|integer',
            'content' => 'required|string|max:255',
            'state' => 'nullable|string|max:50',
            'date' => 'required|date',
        ];
    }
}
