<?php
namespace App\Repositories;
use App\Models\DetailMessage;
class DetailMessageRepository  extends Repository
{ 
    public function __construct(DetailMessage $model){
        $this->model = $model;
    }
}