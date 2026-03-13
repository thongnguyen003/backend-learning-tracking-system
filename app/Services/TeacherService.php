<?php
namespace App\Services;

use App\Repositories\TeacherRepository;
use Illuminate\Support\Facades\Hash;
namespace App\Services;

use App\Repositories\TeacherRepository;

class TeacherService
{
    protected $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function changePassword($id, $data)
    {
        try {
            $teacher = $this->teacherRepository->findById($id);
            if (!$teacher) {
                throw new \Exception("Teacher not found with ID $id");
            }

            if (!Hash::check($data['current_password'], $teacher->password)) {
                throw new \Exception('Current password is incorrect');
            }

            $this->teacherRepository->updatePassword($id, $data['new_password']);

            return response()->json(['message' => 'Password changed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateTeacherProfile($id, $data)
    {
        return $this->teacherRepository->update($id, $data);
    }

    public function findById(int $id)
    {
        return $this->teacherRepository->findById($id);
    }

    public function findByClassId(int $classId)
    {
        return $this->teacherRepository->findByClassId($classId);
    }
}




