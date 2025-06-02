<?php
namespace App\Services;

use App\Repositories\TeacherRepository;

class TeacherService
{
    protected $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
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
?>



