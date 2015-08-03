<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Player;
class DataPlayer{
	public $countWin;
	public $countLose;
	public $games;
	public $allScores;

	public function __construct( $countWin, $countLose, $games, $all_scores ){
		$this->countWin = $countWin;
		$this->countLose = $countLose;
		$this->games = $games;
		$this->allScores = $all_scores;
	}
	public function addWins(){
		$this->countWin++;
	}
	public function addLose(){
		$this->countLose++;
	}
	public function addGames(){
		$this->games++;
	}
	public function addAllScores( $resultScore ){
		$this->allScores += $resultScore;
	}
}

class StatisticController extends MainController{
	public $data;

	public function index( Player $playerModel ){//вывод таблицы
		//$this->data['statistics'] = $playerModel->all();
		$result = ['Андрей'=>120, 'Вова'=>100, 'Олег'=>32 ];//этот массив мы получим, а уже потом разделим
		$resultNames = ["Андрей" , "Вова", "Олег"];
		$resultScores = [120,100,32];
		$noChangeData =  $this->getPlayer( $playerModel, $resultNames );
		$objArray = [];
		$objArray = $this->createPlayersObjects( $noChangeData ); // метод создания массива объектов DataPlayer для хранения и изменения данных выборки
		echo "<pre>".print_r( $objArray ,1)."</pre>";
		$objArray = $this->changeBasicFields( $objArray, $result ); //Изменение основных полей объекта (count_win,count_lose,games)

		echo "<pre>".print_r( $objArray ,1)."</pre>";

		//return view('statistics', $this->data);
	}
	public function getPlayer(Player $playerModel, $resultNames){
		return $playerModel->whereIn('name', $resultNames)->get();
	}							//выборка строк для update where name = result['name']
								// изменение games++, если победитель countWins++, иначе countLose ++;
								//для всех играющих изменить очки
	public function changeBasicFields( array $objArray, array $result ){
		$index = true;
		foreach( $objArray as $key=> &$value ){
			if( $index ){
				$value->addWins();
				$index = false;
			}else $value->addLose();
			$value->addGames();
			$value->addAllScores( $result[$key] );
		}
		return $objArray;
	}
	public function createPlayersObjects( $noChangeData ){
		foreach ($noChangeData as $key => $value) {
			$objArray[ $value['name'] ] = new DataPlayer( $value['count_win'], $value['count_lose'], $value['games'], $value['all_scores'] );
		}
		return $objArray;
	}

}
