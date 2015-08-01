@include("layouts.header")
<? // Передача имен игроков и их кол-ва в JS
	$namesPhp = json_encode( $startNames ); //Имена игроков
	$countNames = json_encode( count( $startNames ) ); //Кол-во игроков
	echo "<script>
				var namesPhp=".$namesPhp.";
				var countNames=".$countNames.";
				var tryes =".$tryes.";
		  </script>";
?>
<script type="text/javascript" src="js/counterPlayers.js"></script>

	<a href="/" class="back">Назад</a>
	<div class="wrap_playground">
		<div class="main playground" id="left_playground">
			<table class="playground_table">

				<tr>
					<th>Имя</th>
					<?for( $i = 1; $i<=$tryes; $i++){?>
						<th> <?=$i?>-я </th>
					<?}?>

					<th>Всего</th>
				</tr>
				@foreach( $startNames as $name )
					<tr>
						<td class='player_names'>{{ $name }}</td>

						<?for( $i = 1; $i<=$tryes; $i++){?>
							<td></td>
						<?}?>

						<td class="all_sum"></td>
					</tr>
				@endforeach

			</table>
		</div>
		<div class="main playground who_stepping"  id="right_playground">


			<p class="now_plaing">Сейчас ходит:</p>
			<p class='player' id='nowPlayer'><?=$startNames[0]?></p>

			<form action="/playground" method="get" id="myform">
				<input type="number" min="0" max="180" name='score[]'>
				<input type="number" min="0" max="180" name='score[]'>
				<input type="number" min="0" max="180" name='score[]'>
				<input type="hidden" name="check" value="1">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
			</form>
			<a id="count">Посчитать</a>

		</div>
		<div id="for_sum" data-v="<?if( !empty( $_REQUEST['sum'] ) )echo $_REQUEST['sum'];?>"></div>
		<div id="for_gamer" data-v="<?if( !empty( $_REQUEST['gamer'] ) )echo $_REQUEST['gamer'];?>"></div>
	</div>
	<div class="result">
		<img src="champion.jpg" alt="чемп" class="champion">
		<p class='champion_name'></p>

		<ul class="no_champ">

		</ul>
		<div class="wrap_a">
			<a href="#">Отыграться</a>
			<a href="#">Новая игра</a>
			<a href="statistics.php">Статистика</a>
		</div>
		<img src="firewark.jpg"  id="firewark" alt="">
		<img src="firewark2.jpg" id="firewark2" alt="">
	</div>
@include("layouts.footer")