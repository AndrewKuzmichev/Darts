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
