@include("layouts.header")
		<div class="main">
			<form  action="{{ url('/playground') }}" method="post" id="myform">
				<p class="plaing">Играют:</p>
					<div class="for_checkboxes">
                        @foreach( $player_names as $player_name )
    						<label>
    							<input type="checkbox" name="player[]" value="{{ $player_name }}"><span>{{ $player_name }}</span>
    						</label><br>
                        @endforeach

					</div>

					<p  class="tryes">Сколько попыток?</p>
					<select  name="tryes">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3" selected>3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

				</form>
				<a href="#" onclick="document.getElementById('myform').submit(); return false;"  id="lets_play">Играть</a>

		</div>
@include("layouts.footer")
