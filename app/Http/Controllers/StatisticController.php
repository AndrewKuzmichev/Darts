<?php

namespace App\Http\Controllers;
use App\Models\Player;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DataPlayer {
	public $countWin;
	public $procentWin;
	public $countLose;
	public $procentLose;
	public $games;
	public $bestResult;
	public $allScores;


	public function __construct( $count_win, $count_lose, $games, $all_scores, $best_result ){
		$this->countWin = $count_win;
		$this->countLose = $count_lose;
		$this->games = $games;
		$this->bestResult = $best_result;
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
	static function countProcentWin( $countWin, $games ){
		return round( ($countWin/$games)*100 );
	}
	static function countProcentLose( $countLose, $games ){
		return round( ($countLose/$games)*100 );
	}
}

class StatisticController extends MainController{
	public $data;

	public function index( Player $playerModel ){//вывод таблицы

		$result = ['Андрей'=>120, 'Максим Петров'=>20 , 'Вова'=>10];//этот массив мы получим, а уже потом раздели
		$resultThrow = ['Андрей'=>120, 'Максим Петров'=>20 , 'Вова'=>10];//еще один массив, с наилучшими попытками

		foreach( $result as $key => $value ){
			$testResultNames[] = $key;
		}

		echo "<pre>".print_r( $testResultNames ,1)."</pre>" ;
		$resultNames = ['Андрей', "Максим Петров" , "Вова"];

		$objArray = [];

		$noChangeData =  $this->getPlayer( $playerModel, $resultNames );
		$objArray = $this->createPlayersObjects( $noChangeData ); // метод создания массива объектов DataPlayer для хранения и изменения данных выбор
		$objArray = $this->changeBasicFields( $objArray, $result, $resultNames); //Изменение основных полей объекта (count_win,count_lose,games)
		echo "<pre>".print_r( $objArray ,1)."</pre>" ;
		$this->updateFields($noChangeData, $objArray);


		$this->data['statistics'] = $playerModel->orderBy('procent_win',"DESC")->get();
		return view('statistics', $this->data);
	}
	private function updateFields( $noChangeData, $objArray ){
		foreach ($noChangeData as  &$saveData) {
			foreach ($objArray as $key => $objData) {
				if( $saveData['name'] == $key ){
					$saveData->count_win = $objData->countWin;
					$saveData->procent_win = $objData->procentWin;
					$saveData->procent_lose = $objData->procentLose;
					$saveData->count_lose = $objData->countLose;
					$saveData->best_result = $objData->bestResult;
					$saveData->games = $objData->games;
					$saveData->all_scores = $objData->allScores;
					$saveData->save();
				}
			}
		}
	}
	public function changeBasicFields( array $objArray, array $result, array $resultNames){

		foreach( $objArray as $key=> &$value ){
			if( $key == $resultNames[0] ){
				$value->addWins();
			}else $value->addLose();

			if( $value->bestResult < $result[$key] ){//лучшая игра
				$value->bestResult = $result[$key];
			}
			$value->addGames();
			$value->procentWin = DataPlayer::countProcentWin( $value->countWin, $value->games );
			$value->procentLose = DataPlayer::countProcentLose( $value->countLose, $value->games );
			$value->addAllScores( $result[$key] );
		}
		return $objArray;
	}
	public function createPlayersObjects( $noChangeData ){
		foreach ($noChangeData as $key => $value) {
			$objArray[ $value['name'] ] = new DataPlayer( $value['count_win'], $value['count_lose'], $value['games'],$value['all_scores'], $value['best_result'] );
		}
		return $objArray;
	}
	public function getPlayer(Player $playerModel, $resultNames){
		return $playerModel->whereIn('name', $resultNames)->get();
	}							//выборка строк для update where name = result['name']
								// изменение games++, если победитель countWins++, иначе countLose ++;
								//для всех играющих изменить очки

}
