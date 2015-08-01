<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/css/style.css" media="screen">
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="/js/script.js"></script>
		<title></title>
	</head>
	<body>

		<a href="index.php" class="back">Назад</a>
		<div class="wrap_playground">
			<div class="main playground" id="left_playground">
				<table class="playground_table">
					<tr>
						<th>Имя</th>
						<th>1-я</th>
						<th>2-я</th>
						<th>3-я</th>
						<th>Всего</th>
					</tr>
					<tr>
						<td>Андрей</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Андрей</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Андрей</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

				</table>
			</div>
			<div class="main playground who_stepping"  id="right_playground">
				<p class="now_plaing">Сейчас ходит:</p>
				<p class='player'>Максим Петров</p>

				<input type="number" min="0" max="180">
				<input type="number" min="0" max="180">
				<input type="number" min="0" max="180">

				<a href="#" id="count">Посчитать</a>
			</div>
		</div>
		<div class="result">
			<img src="champion.jpg" alt="чемп" class="champion">
			<p class='champion_name'>Максим Петров - 89</p>

			<ul class="no_champ">
				<li><span>2.</span>Андрей - 71</li>
				<li><span>3.</span>Максим Волков - 70</li>
				<li><span>4.</span>Олег - 4</li>
			</ul>
			<div class="wrap_a">
				<a href="#">Отыграться</a>
				<a href="#">Новая игра</a>
				<a href="statistics.php">Статистика</a>
			</div>
			<img src="firewark.jpg"  id="firewark" alt="">
			<img src="firewark2.jpg" id="firewark2" alt="">
		</div>

	</body>
</html>
