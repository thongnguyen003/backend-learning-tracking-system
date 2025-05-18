<?php
namespace App\Services;

use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class StudentService
{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }
    public function changePassword($id, $data)
    {
        try {
            $student = $this->studentRepository->findById($id);
            if (!$student) {
                throw new \Exception("Student not found with ID $id");
            }

            if (!Hash::check($data['current_password'], $student->password)) {
                throw new \Exception('Current password is incorrect');
            }

            $this->studentRepository->updatePassword($id, $data['new_password']);

            return response()->json(['message' => 'Password changed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateStudentProfile($id, $data)
    {
        return $this->studentRepository->update($id, $data);
    }
}
