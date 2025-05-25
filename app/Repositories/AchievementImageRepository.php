<?php
namespace App\Repositories;
use App\Models\AchievementImage;
class AchievementImageRepository  extends BaseRepository {
    public function __construct(AchievementImage $model){
        parent::__construct($model);  
    }
    public function create(array $data){
        return parent::create($data);
    }
    public function update(int $id,array $data){
        return parent::update( $id, $data);
    }
    public function delete(int $id){
        return parent::delete($id);
    }
}