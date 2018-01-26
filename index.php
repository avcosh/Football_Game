<?php
// Подключаем файл, описывающий класс эмулятора
include_once "Football_Emulator.php";
// Инстанцируем объекта класса эмулятора
$emulator = new Football_Emulator();

// Рисуем кнопку
echo $emulator->html_button();
if (isset($_GET['run'])) {
	// Если кнопка была нажата, расчитываем силу команд
    $emulator->calculate_power();
    // Рисуем таблицу с силами команд
    echo $emulator->html_powertable();
    // Эмулируем турнир
	$emulator->emulate_championship();
	// Рисуем таблицы очков
	echo $emulator->html_scoreboard();
}
