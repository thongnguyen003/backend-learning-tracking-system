<?php
namespace App\Services;
use App\Repositories\AchievementRepository;
class AchievementService extends BaseService{
    public function __construct(AchievementRepository $repo){
        parent::__construct($repo);
    }
    protected function getByStudentId($id){
        return $this->service->getByStudentId($id);
    }
}