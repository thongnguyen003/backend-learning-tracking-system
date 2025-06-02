<?php
namespace App\Repositories;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminRepository extends Repository{
    public function __construct( Admin $model){
        $this->model = $model;
    }
}
?>      
