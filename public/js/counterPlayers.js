$(document).ready(function() {
	//Реализация счетчика тех, кто ходит
	var namesJs = namesPhp;
	var index = 1;
	var number_try = 0;
	var flagCheckWin = false;
	$("body").keypress(function(e){

		if( ( e.keyCode==13 ) && ( $('.result').css('display') == 'none' ) ){
			$('#count').click();
		}
	});
	$("#count").click(function(event){//Посчет суммы бросков


		//подсчет суммы хода, внесение в таблицу результата
		var sum = 0;
		var gamer = $("#nowPlayer").text();
		var flag = false;
		var flagForSum = false;
		var errors = [];

		$("#myform").find('input[type="number"]').each(function(index){//подсчет суммы попытки
			var val = parseInt( $(this).val() );

			if ( isNaN( val ) ) {
				errors.push( 'Ошибка в ' +(index+1)+  "-м поле" );
			}else if( val < 0 ){
				errors.push( (index+1)+"-e поле.Не может быть отрицательным!" );
			}else  sum = sum + val;
		});


		if( sum === 0 ){//решение проблемы ввода нулей
			sum = 1000;
		}

		event.preventDefault();
		if( ( errors.length == 0 ) || ( number_try >= tryes*countNames ) ){
			//счетчик ходов

				number_try++;
				if( number_try < tryes*countNames ){
					if( index < countNames ){
						$("#nowPlayer").html( namesJs[index] );
					}
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
				$("#myform").find('input[type="number"]').each(function(){//обнуление введенных результатов
					$(this).val('');
				});
				$("input[type='number']:first-child").focus();
			//конец счетчика ходов

			$.ajax({
				    type: "get",
				    url: "playground",
					data: { sum: sum, gamer: gamer},
					success: function(data){
						var gamer_name =  $(data).find("#for_gamer").attr('data-v');
						var sum_try = parseInt( $(data).find("#for_sum").attr('data-v') );
						if( sum_try === 1000 ){//исправление ошибки с вводом нулей
							sum_try = 0;
						}
						var sum_total = 0;
						plaing(gamer_name, sum_try, sum_total, flag, flagForSum);
					}
			});
		}else {
			alert(errors )+'</br>';
		}

		//подведение результатов
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

				for (var i = 0; i < countNames; i++) {//формирование массива имен и массива результатов по убыванию
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

			}
		//конец подведения результатов

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
