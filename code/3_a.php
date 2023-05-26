<?php
session_start();
if (!is_dir('ads')) { //если нет папки ads, создаем ее, в ней будем хранить объявления
	mkdir('ads');
}
function arrToStr ($arr, $sep = " ") { //функция для удобного вывода массива
	$str = "";
	foreach ($arr as $elem) {
		$str .= $elem . $sep;
	}
	return $str;
}


function getFiles($dir) { //рекурсивный обход файлов
	$files = array_diff(scandir($dir), ['..', '.']);
	$result = [];
	foreach ($files as $file) {
		$path = $dir . '/'. $file;
		if (is_dir($path)) {
			$result = array_merge($result, getFiles($path));
		} else {
			array_push($result, $path);
		}
	}
	return $result;
}

$files = getFiles('ads');
foreach ($files as $key => $file) { //в массив $files попадают все директории, оставляем только те, которые являются объявлениями, они записаны в виде категория/электронная почта/заголовок
	if (substr_count($file, '/') != 3) {
		unset($files[$key]);
	}
}
sort($files);

foreach ($files as $key => $file) {
	$files[$key] = substr($file, 4); //удаляем из пути папку /ads, чтобы удобнее было работать
}


function convertArrayToAdArray($array) { //функция, которая считывает содержимое файла и сливает с массивом оставшихся после строчек 30-35 директорий
	//далее полученные массивы(поля отсортированы в соответствии с выводом в таблицу) добавляются в массив $adArray
	$adArray = [];
	foreach ($array as $key => $value) {
		$content = file_get_contents('ads/' . $value);
		//var_dump('./' . $value);
		$tmp = preg_split("/\//", $value);
		$adItem = [];
		array_push($adItem, $tmp[0]);
		array_push($adItem, explode('.', $tmp[2])[0]);
		array_push($adItem, $content);
		array_push($adItem, $tmp[1]);
		array_push($adArray, $adItem);
	}
	return $adArray;
}


$adArr = convertArrayToAdArray($files); //вызываем эту функцию
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>lab3</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="ad">
        <div class="form">
			<form action="" method="POST" class="adForm">
				<div class="nameContainer">Электронная почта: <input type="text" name="email">
				</div>
				<div class="surnameContainer">Категория: <input type="text" name="category">
				</div>
				<div class="ageContainer">Заголовок: <input type="text" name="header">
				</div>
				<div class="ageContainer">Текст объявления: <input type="text" name="content">
				</div>
				<input name="btn" type="submit" value="Add">
			</form>
		</div>
		<div class="adField">
			<div class="adItem">
				<div class="categoryHeader">Категория</div>
				<div class="headerHeader">Заголовок</div>
				<div class="textHeader">Текст</div>
				<div class="emailHeader">Электронная почта</div>
			</div>

			<?php
			foreach ($adArr as $keyAdArr => $ad) { //проход по массиву
				$str = '<div class="adItem">'; //формируем строку с объялвением
				foreach ($ad as $keyAd => $value) { //проход по подмассивам
					$str .= "<div>" . $value . "</div>"; //вставляем в строку строки с полями таблицы
				}
				$str .= '</div>'; //конец строки
				echo $str; //выводим ее в таблицу
				$str = '';
			}
			if (isset($_POST['btn'])) { //проверка существования отправленных данных по кнопке
			switch ($_POST['btn']) {
				case 'Add': //по кнопке Add

					if($_POST['email'] && $_POST['category'] && $_POST['header'] && $_POST['content']) {
						if (!is_dir('ads/' . $_POST['category'] . '/' . $_POST['email'])) { //проверка, есть ли такой пользователь в выбранной категории
							mkdir('ads/' . $_POST['category'] . '/' . $_POST['email'], 0777, true);
						}
						$fp = fopen('ads/' . $_POST['category'] . '/' . $_POST['email'] . '/' . $_POST['header'] . '.txt', 'w+'); //создаем или переписываем файл, если он есть
						fwrite($fp, $_POST['content']); //записываем данные
						fclose($fp); //закрываем
					}
			}
		}
		?>
		</div>

	</div>

</body>
</html>
