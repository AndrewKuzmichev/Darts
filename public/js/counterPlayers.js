$(document).ready(function() {
	$("#count").click(function(event){
		var sum = 0;
		var gamer = $("#nowPlayer").text();
		var flag = false;
		var flagForSum = false;

		$("#myform").find('input[type="number"]').each(function(){//подсчет суммы попытки
			var val = parseInt( $(this).val() );
			sum = sum + val;

		});

		$("#myform").find('input[type="number"]').each(function(){//обнуление введенных результатов
			$(this).val('');
		});

		event.preventDefault();
		$.ajax({
			    type: "get",
			    url: "playground",
				data: { sum: sum, gamer: gamer},
				success: function(data){
					var gamer_name =  $(data).find("#for_gamer").attr('data-v');
					var sum_try =  $(data).find("#for_sum").attr('data-v');
					var sum_total = 0;
					plaing(gamer_name, sum_try, sum_total, flag, flagForSum);
				}
			});


	});

	//Реализация счетчика тех, кто ходит
	var namesJs = namesPhp;
	var index = 1;
	var number_try = 0;
	var flagCheckWin = false;

	$("#count").click(function(){
		number_try++;
		if( number_try < tryes*countNames ){
			if( index < countNames )
			$("#nowPlayer").html( namesJs[index] );

			if( index == countNames ){
				index = 0;
				$("#nowPlayer").html( namesJs[index] );
			}
			index++;

		}else if( number_try == tryes*countNames ){
			$("#count").css({
							'width': '551px',
							'position': 'absolute',
							'height': '161px',
							'background': 'white',
							'top': '181px',
							'right': '118px',
							'font-size': '101px'
			});
			$("#count").html('Результат');
		}

		if( number_try > tryes*countNames )
			flagCheckWin = true;

		if( flagCheckWin ){
			//создать массив из значений сумм с ключами в виде имен из массива namesJs
			var indexAr = 0;
			var preSortResultAr = [];
			var testSortResultAr = [];
			$('.all_sum').each(function(){
				var value_result = parseInt( $(this).html() );
				preSortResultAr[namesJs[indexAr]] = value_result;// массив с ключами-именами и суммами
				testSortResultAr[indexAr] = value_result;//массив в суммами
				indexAr++;
			});

			for (var i = 0; i < countNames; i++) {
				max = testSortResultAr[i];
				for (var j = i+1; j < countNames; j++) {
					if( testSortResultAr[j] > max ){
						max = testSortResultAr[j];
						var between = testSortResultAr[i];
						testSortResultAr[i] = testSortResultAr[j];
						testSortResultAr[j] = between;

					}
				}

			}

			var result = [];//конечный массив array(  'Вован'=> 3223, 'Андрей'=>2332, 'Олег'=>23 )
			for ( var i = 0; i < testSortResultAr.length; i++ ) {
				for ( var j in preSortResultAr ) {
					if( testSortResultAr[i] == preSortResultAr[j] ){
						result[j] = testSortResultAr[i];
					}
				}
			}

			var resultNames = [];
			var resultScores = [];
			var indexResult = 0;
			for (var key in result) {
				if (  arrayHasOwnIndex( result, key ) ) {
					resultNames[indexResult] = key;
					resultScores[indexResult] = result[key];
				}
				indexResult++;
			}

			$('.champion_name').html( resultNames[0]+' - '+resultScores[0]);
			for (var i = 1; i < resultScores.length; i++) {
				$('.no_champ').append('<li><span>'+(i+1)+'.</span>'+resultNames[i]+' - '+resultScores[i]+'</li>');
			}
			 $('.result').css('display','block');
			// for (var key in result) {
			// 	if (  arrayHasOwnIndex( result, key ) ) {
			// 		console.log( result[key] );
			// 	}
			// }

			// var flagResult = true;
			// var indexResult = 1;
			// for (var key in result) {
			// 	if ( flagResult ) {
			// 		$('.champion_name').html( key +' - '+result[key]);
			// 		flagResult = false;
			// 	}
			//
			// 	var a = indexResult +1 ;
			// 	console.log(a);
			// 	$('.no_champ').append('<li><span>'+a+'.</span>'+key+' - '+result[key]+'</li>');
			// 	indexResult++;
			//
			// }
			//
			// var indexResult = 1;
			// for (var key in result) {
			// 	var a = indexResult +1 ;
			// 	console.log(a);
			// 	$('.no_champ').append('<li><span>'+a+'.</span>'+key+' - '+result[key]+'</li>');
			// 	indexResult++;
			//
			// }
			// //console.log( $('.result').html() );
			// $('.result').css('display','block');

		}
	});
//ФУНКЦИИ
	function arrayHasOwnIndex(array, key) {//Для for in
		return array.hasOwnProperty(key);
	}
	//поиск максимального значения
	var max_result = function(){
		var max = 0;
		$('.all_sum').each(function(){
			var value_sum = parseInt( $(this).html() );
				if( value_sum > max ){
					max = value_sum;
			}
		});
		return max;
	}

	var plaing = function( gamer_name, sum_try, sum_total, flag, flagForSum){//функция внесения очков в таблицу и подсчет общей суммы очков
		$(".player_names").each(function(){
			if( ( $(this).text() == gamer_name ) && ( $(this).next() != '' ) ){
				$(this).nextUntil('.all_sum').each(function(){ // внесение суммы попытки в таблицу соответствующего игрока
					if( ($(this).text() == '') && (flag == false) ){
						$(this).html(sum_try);
						flag = true;
					}else if( !( $(this).next().hasClass('all_sum') )&& ( $(this).next().text() == '') && (flag == false) ){
							$(this).next().html(sum_try);
							flag = true;
						}
				});
				$(this).nextUntil(".all_sum").each(function(){//подсчет суммы набранных очков
					if( $(this).text() != '' ){
						flagForSum = true;
						sum_total = sum_total + parseInt( $(this).html() );
					}else {
						flagForSum = false;
						sum_total = 0;
					}
				});

				if( flagForSum ){//вывод поля Всего
					$(this).parent().find('.all_sum').html( sum_total );
				}

			}
		});
	}






});// Конец ready
