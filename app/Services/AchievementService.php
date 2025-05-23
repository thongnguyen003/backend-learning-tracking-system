<?php
namespace App\Services;
use App\Repositories\AchievementRepository;
use App\Repositories\AchievementImageRepository;
use App\Models\AchievementImage;
class AchievementService extends BaseService{
    public function __construct(AchievementRepository $repo){
        parent::__construct($repo);
    }
    public function getByStudentId($id){
        return $this->repository->getByStudentId($id);
    }
    public function create(array $data){
        $infoAchievement = $data['infoAchievement'];
        $achievement = $this->repository->create($infoAchievement);
        $achievementImage = new AchievementImageRepository(new AchievementImage);
        foreach($data['links'] as $value){
            $arrayImage=['achievement_id'=>$achievement->id,'link'=>$value];
            $achievementImage->create($arrayImage);

        }
        if($achievement){
            return true;
        }
    }
    public function update(int $id, array $data){
        return parent::update($id,$data);
    }
}