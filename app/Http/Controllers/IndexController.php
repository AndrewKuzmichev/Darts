<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Player;

class IndexController extends MainController{

    public function index( Player $playerModel ){
        $this->data['player_names'] = $playerModel->getPlayerNames();
        return view( 'main', $this->data );
    }
    public function array_shuffle($array) {
		if (shuffle($array)) {
			return $array;
		} else {
			return FALSE;
		}
	}
    public function playground( Request $request ){

        if( !empty( $request->input('player') ) ){
            $this->data['startNames'] = $this->array_shuffle( $request->input('player') );
            $this->data['tryes'] = $request->input('tryes');
            session([ 'name_players' => $this->array_shuffle($request->input('player')) ]);
            session([ 'tryes' => $request->input('tryes') ]);
        }else {
            $this->data['startNames'] = session('name_players');
            $this->data['tryes'] = session('tryes');
        }

        return view( 'playground', $this->data );
    }
    public function plaing( Request $request ){


         $this->data['startNames'] =  session('name_players');
         $this->data['tryes'] =  session('tryes');
         $this->data['scores'] = $request->input('score');

        return view( 'playground', $this->data );
    }

}
