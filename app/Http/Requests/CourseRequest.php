<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // app/Http/Requests/CourseRequest.php
    public function rules()
    {
        return [
            'course_student_id' => 'required|integer',
            'message_id' => 'nullable|integer',
            'content' => 'required|string',
            'state' => 'required|string',
            'date' => 'required|date',
        ];
    }

}
