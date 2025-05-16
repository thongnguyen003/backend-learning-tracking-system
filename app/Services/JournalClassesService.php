<?php
    namespace App\Services;
    use App\Repositories\JournalClassesRepository;
    class JournalClassesService{
        protected $repository;
        public function __construct(JournalClassesRepository $reponsitory){
            $this->repository = $reponsitory;
        }

        public function getAll(){
            return $this->repository->getAll();
        }
        
        public function getById($id){
            return $this->repository->findById($id);
        }

        public function create(array $data){
            return $this->repository->create($data);
        }

        public function update($id, array $data){
            return $this->repository->update($id,$data);
        }

        public function delete($id){
            return $this->repository->delete($id);
        }
    }
?>