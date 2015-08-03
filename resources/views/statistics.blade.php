@include("layouts.header")

	<a href="/" class="back">Назад</a>
		<div class="statistic">
			<table class="statistic_table playground_table ">
				<tr>
					<th>Имя</th>
					<th class="green">Побед</th>
					<th class="red">Поражений</th>
					<th>Игр</th>
					<th class="green">%,побед</th>
					<th class="red">%,поражений</th>
					<th>Лучший результат</th>
					<th>Лучший бросок</th>
					<th>Всего очков</th>
				</tr>
				<? $index = 1;?>
				@foreach( $statistics as $player )
					<tr>
						<td><span>{{$index}}.</span>{{ $player['name'] }}</td>
						<td class="green">{{ $player['count_win'] }}</td>
						<td class="red">{{ $player['count_lose'] }}</td>
						<td>{{ $player['games'] }}</td>
						<td class="green">{{ $player['procent_win'] }}</td>
						<td class="red">{{ $player['procent_lose'] }}</td>
						<td>{{ $player['best_result'] }}</td>
						<td>{{ $player['best_throw'] }}</td>
						<td>{{ $player['all_scores'] }}</td>
					</tr>
					<?$index++;?>
				@endforeach
				<tr></tr>
			</table>

		</div>

@include("layouts.footer")
