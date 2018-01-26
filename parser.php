/*
index.php - главный файл, открывать в браузере
Football_Emulator.php - файл класса эмулятора, в нём вся логика
football.sql - файл для генерации таблицы для базы данных
datautf.csv - ваш файл со статистикой команд
parser.php - файл для генерации таблицы базы данных, если вдруг не получится через sql создать. Он как альтернативный вариант, там нет комментариев.
*/
<?php
//ALTER TABLE football MODIFY country VARCHAR(100) CHARACTER SET utf8;
$host = '127.0.0.1';
$db = 'football';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
$firstline = false;

$file = fopen("datautf.csv", "r");
if ($file) {
	while (($line = fgets($file)) !== false) {
		if (!$firstline)
			$firstline = true;
		else {
			$linearray = explode(",", $line);
			$goals     = explode(" - ", $linearray[5]);

			$stmt = $pdo->prepare("INSERT INTO football (country, games, won, tie, lost, goals_scored, goals_missed) VALUES (:country, :games, :won, :tie, :lost, :goals_scored, :goals_missed)");
			$stmt->bindParam(':country', $linearray[0]);
			$stmt->bindParam(':games', $linearray[1]);
			$stmt->bindParam(':won', $linearray[2]);
			$stmt->bindParam(':tie', $linearray[3]);
			$stmt->bindParam(':lost', $linearray[4]);
			$stmt->bindParam(':goals_scored', $goals[0]);
			$stmt->bindParam(':goals_missed', $goals[1]);
			$stmt->execute();
		}
	}

	fclose($file);
}