<?php
/*
 * Класс эмулятора, инкапсулирующий расчёт сил команд и
 * эмулирующий футбольный чемпионат с выводом турнирных
 * таблиц.
 */
class Football_Emulator {
	// Настройки базы данных
	private
		$host = '127.0.0.1',
		$db = 'football',
		$user = 'root',
		$pass = '',
		$charset = 'utf8';
	// Храним подключение к базе данных
	private $pdo;
	// Таблица сил команд
	private $powertable = array();
	// Таблица результатов матчей
	private $scoreboard = array();

	// Конструктор класса - выполняется при создание объекта, т.е. в самом начале
	function __construct() {
		// Подключаемся в базе данных
		$dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		$this->pdo = new PDO($dsn, $this->user, $this->pass, $opt);
	}

	// Расчёт сил команд
	function calculate_power() {
		// Читаем базу данных и сохраняем результат
		$stmt = $this->pdo->prepare("SELECT country, games, won, tie, lost, goals_scored, goals_missed FROM football");
		$stmt->execute();
		$result = $stmt->fetchAll();

		// Для каждой команды расчитываем её силу атаки и защиты
		foreach ($result as $res) {
			// Расчёт силы атаки равен % выйгранных игр * % забитых голов
			$power_attack = ($res['won'] / $res['games']) * $res['goals_scored'] / ($res['goals_scored'] + $res['goals_missed']);
			// Расчёт силы защиты равен % выйгранных игр / % пропущенных голов
			$power_defend = ($res['won'] / $res['games']) / ($res['goals_missed'] / ($res['goals_scored'] + $res['goals_missed']));

			// Записываем результаты в таблицу сил команд
			array_push($this->powertable, [
				'country' => $res['country'],
				'power_attack' => $power_attack,
				'power_defend' => $power_defend
			]);
		}
	}

	// Эмулирует чемпионат
	function emulate_championship() {
		// Номер текущего раунда
		$round_counter = 0;
		// Список ещё нераспределенных команд текущего раунда
		$teams = array_column($this->powertable, 'country');

		// Эмуляция турнира
		do {
			// Жеребьевка
			$this->tossup($teams, $round_counter);
			// Эмуляция раунда
			$teams = $this->emulate_round($this->scoreboard[$round_counter]);
			// Следующий раунд
			$round_counter = $round_counter + 1;
			// Эмулируем турнир до тех пор, пока больше 1 пары
			// К этому моменту эта пара уже будет сыгранна
		} while(count($this->scoreboard[$round_counter-1]) > 1);
	}

	// Жеребьевка
	// $teams - список нераспределенных команд
	// $round_counter - номер текущего раунда
	function tossup($teams, $round_counter) {
		$this->scoreboard[$round_counter] = array();
		// Пока есть нераспределенные команды
		while (count($teams) > 0) {
			// Выбираем 2 случайные команды из списка нераспределенных
			$chosen = array_rand($teams, 2);
			// Помещаем их в таблицу очков
			array_push($this->scoreboard[$round_counter], [
				'team_A' => $teams[$chosen[0]],
				'team_B' => $teams[$chosen[1]]
			]);
			// Убираем выбранные команды из списка нераспределенных
			unset($teams[$chosen[0]]);
			unset($teams[$chosen[1]]);
		}
	}

	// Эмулирование раунда
	// $pairs - таблица пар команд
	// Обращение идёт по ссылке (&), поскольку в функции меняется значение переменной - записываются результаты матча
	// Функция возвращает список команд-победителей, необходимых для следующего раунда
	function emulate_round(&$pairs) {
		// Таблица команд-победителей
		$teams = array();
		foreach ($pairs as &$pair) {
			// Находим силы для обоих команд из таблицы сил команд
			$team_A = $this->powertable[array_search($pair['team_A'], array_column($this->powertable, 'country'))];
			$team_B = $this->powertable[array_search($pair['team_B'], array_column($this->powertable, 'country'))];
			do {
				// Расчитываем кол-во голов обоих команд
				// Случайное число от 0 до 20 * силу команды / защиту соперника
				$team_A_goals = rand(0, 20 * $team_A['power_attack'] / $team_B['power_defend']);
				$team_B_goals = rand(0, 20 * $team_B['power_attack'] / $team_A['power_defend']);
				// и повторяем расчёты, если они оказываются одинаковыми
			} while ($team_A_goals == $team_B_goals);
			// Записываем результаты обратно в таблицу пар команд
			$pair['team_A_goals'] = $team_A_goals;
			$pair['team_B_goals'] = $team_B_goals;
			// Выигравшую команду записываем в таблицу победителей
			if ($team_A_goals > $team_B_goals)
				array_push($teams, $team_A['country']);
			else
				array_push($teams, $team_B['country']);
		}
		return $teams;
	}

	// Рисуем кнопку запуска чемпионата
	function html_button() {
		return "<form><input type=\"hidden\" name=\"run\" value=\"true\"><input type=\"submit\" value=\"Запустить чемпионат\"></form>";
	}

	// Рисуем таблицу сил команд
	function html_powertable() {
		$html = "<table><caption>Таблица сил команд</caption><tr><th>Страна</th><th>Сила атаки</th><th>Сила защиты</th></tr>";
		foreach ($this->powertable as $row) {
			$html .= "<tr><td>". $row['country'] ."</td><td>". $row['power_attack'] ."</td><td>". $row['power_defend'] ."</td></tr>";
		}
		$html .= "</table>";
		return $html;
	}

	// Рисуем таблицу очков
	function html_scoreboard() {
		$html = "";
		$round_counter = 1;
		foreach ($this->scoreboard as $round) {
			$html .= "</br><table><caption>Раунд ". $round_counter ."</caption><tr><th>Команда 1</th><th>Счёт</th><th>Команда 2</th></tr>";
			foreach ($round as $pair) {
				$html .= "<tr><td>". $pair['team_A'] ."</td><td>". $pair['team_A_goals'].":". $pair['team_B_goals'] ."</td><td>". $pair['team_B'] ."</td>";
			}
			$html .= "</table>";
			$round_counter = $round_counter + 1;
		}
		return $html;
	}
}