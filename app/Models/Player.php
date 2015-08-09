<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model{
    protected $fillable = ['name','count_win','count_lose', 'games','all_scores'];
    public $timestamps = false;
    
    public function getPlayerNames(){
        return $this->get()->pluck('name');
    }

}
