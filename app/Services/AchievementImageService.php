<?php
namespace App\Services;
use App\Repositories\AchievementImageRepository;
class AchievementImageService extends BaseService{
    public function __construct(AchievementImageRepository $repo){
        parent::__construct($repo);
    }
    public function getByStudentId($id){
        return $this->repository->getByStudentId($id);
    }
    public function create(array $data){
        return parent::create($data);
    }
    public function update(int $id, array $data){
        return parent::update($id,$data);
    }
}