<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Player;

class MainController extends Controller{
    public function __construct( ){
        $this->data = [];
    }
}
