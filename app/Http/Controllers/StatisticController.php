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
	public $bestThrow;
	public $allScores;


	public function __construct( $count_win, $count_lose, $games, $all_scores, $best_result, $best_throw){
		$this->countWin = $count_win;
		$this->countLose = $count_lose;
		$this->games = $games;
		$this->bestResult = $best_result;
		$this->bestThrow = $best_throw;
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


	public function index( Player $playerModel, Request $request ){//вывод таблицы

		if( !empty($request->input('resultNames')) && !empty($request->input('resultScores')) ){

			session([ 'resultNames' =>  $request->input('resultNames') ]);
			session([ 'resultScores' =>  $request->input('resultScores') ]);

			$resultNames = session('resultNames');

			$resultScores = session('resultScores');

			echo "<pre>".print_r( $resultNames ,1)."</pre>";
			echo "<pre>".print_r( $resultScores ,1)."</pre>";

			foreach( $resultNames as $key=>$name ){
				$result[$name] = $resultScores[$key];
			}

			$resultThrow = ['Вова'=>1000, 'Максим Петров'=>200 , 'Андрей'=>1];//еще один массив, с наилучшими попытками


			$objArray = [];

			$noChangeData =  $this->getPlayer( $playerModel, $resultNames );
			$objArray = $this->createPlayersObjects( $noChangeData ); // метод создания массива объектов DataPlayer для хранения и изменения данных выбор
			$objArray = $this->changeBasicFields( $objArray, $result, $resultNames, $resultThrow); //Изменение основных полей объекта (count_win,count_lose,games)

			$this->updateFields($noChangeData, $objArray);

		}else {
			$this->data['statistics'] = $playerModel->orderBy('count_win',"DESC")->get();
			return view('statistics', $this->data);
		}
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
					$saveData->best_throw = $objData->bestThrow;
					$saveData->games = $objData->games;
					$saveData->all_scores = $objData->allScores;
					//$saveData->save();
				}
			}
		}
	}
	public function changeBasicFields( array $objArray, array $result, array $resultNames, array $resultThrow){

		foreach( $objArray as $key=> &$value ){
			if( $key == $resultNames[0] ){
				$value->addWins();
			}else $value->addLose();

			if( $value->bestResult < $result[$key] ){//лучшая игра
				$value->bestResult = $result[$key];
			}
			if( $value->bestThrow < $resultThrow[$key] ){//лучший бросок
				$value->bestThrow = $resultThrow[$key];
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
			$objArray[ $value['name'] ] = new DataPlayer( $value['count_win'], $value['count_lose'], $value['games'],$value['all_scores'], $value['best_result'], $value['best_throw'] );
		}
		return $objArray;
	}
	public function getPlayer(Player $playerModel, $resultNames){
		return $playerModel->whereIn('name', $resultNames)->get();
	}							//выборка строк для update where name = result['name']
								// изменение games++, если победитель countWins++, иначе countLose ++;
								//для всех играющих изменить очки

}
