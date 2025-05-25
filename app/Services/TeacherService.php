<?php
    namespace App\Services;
    use App\Repositories\TeacherRepository;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Http\JsonResponse;

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
    }
?>



