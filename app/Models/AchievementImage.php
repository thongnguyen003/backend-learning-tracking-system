<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Achievement;
class AchievementImage extends Model
{
    protected $table = "achievement_images";
    protected $fillable = [
        'link',
        'achievement_id',
    ];
    public function achievement(){
        return $this->belongsTo(Achievement::class,"achievement_id");
    }
}
