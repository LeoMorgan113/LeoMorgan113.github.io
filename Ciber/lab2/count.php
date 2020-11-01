<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style_lab2.css">
	<title>Document</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<?php
			print_r($_POST);
			$q_tepl = $_POST['q_telp'];//Питомі тепловтрати будівлі
			$temp_region = $_POST['temp_region'];// t регіон
			$q_sqr = $_POST['sqr'];//Опалювальна площа

			$N_people = $_POST['N_people'];//Кількість людей

			$T_input_water = $_POST['T_input_water'];//Температура вхідної води
			$T_end_bak = $_POST['T_end_bak'];//Кінцева температура бака

			$T_water_shower = $_POST['T_water_shower'];//Температура води при прийомі душу
			$N_shower = $_POST['N_shower'];//Кількість прийомів душу
			$q_aver_shower = 40;//Середній обсяг води в душі — в середньому 30 - 50 літрів

			$T_water_bath = $_POST['T_water_bath'];//Температура води при прийомі ванни
			$N_bath = $_POST['N_bath'];//Кількість прийомів ванни
			$q_aver_bath = 170;//Середній обсяг води в ванній — в середньому 140-200 літрів

			$type_choice = $_POST['choice'];
			$duration = $_POST['duration'];//Задаємо тривалість для розрахунку потужність
			$power = $_POST['power'];//Задаємо потужність для розрахунку тривалості

			$T_inside_build = $_POST['T_inside_build'];//Розрахункова температура в середині будівлі

			$q_shower = $N_shower*$q_aver_shower;
			$q_bath = $N_bath*$q_aver_bath;

			$Q_T_shower = $q_shower*(($T_water_shower - $T_input_water)/($T_end_bak - $T_input_water));
			$Q_T_bath =$q_bath*(($T_water_bath - $T_input_water)/($T_end_bak - $T_input_water));

			$p = 998.23; // густина води при температурі 60 С
			$Q_hot_water = ($Q_T_shower + $Q_T_bath)/$p; //м3/добу

			$w_hot_water = 1.163 * $Q_hot_water*($T_end_bak - $T_input_water); // кВт*год, енергія для нагріву

			if($type_choice == "power_choice"){
			    $power = $w_hot_water/$duration; //потужність нагрівача
			}else if($type_choice == "duration_choice"){
			    $duration = $w_hot_water/$power;
			}


			?>

			<div>Було вказано тип вибору <?php echo $type_choice?></div>
			<div>Температура гарячої води <?php echo $Q_hot_water?> </div>
			<div>Енергія <?php echo $w_hot_water?></div>
			<div>Потужність <?php echo $power ?></div>
			<div>Тривалість <?php echo $duration ?></div>
		</div>
	</div>
	

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/jquery-3.4.1.min.js"></script>
</body>
</html>