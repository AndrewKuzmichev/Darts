<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model{
    public function getPlayerNames(){
        return $this->get()->pluck('name');
    }
}
