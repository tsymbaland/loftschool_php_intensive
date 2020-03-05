<?php
require_once 'AbstractTariff.php';
require_once 'BasicTariff.php';
require_once 'StudentTariff.php';
require_once 'HourlyTariff.php';
require_once 'DailyTariff.php';
echo "<hr> --- БАЗОВЫЙ --- <hr>";
try {
	echo ">>> просто базовый<br>";
	new BasicTariff(200, 120, 30, []);
} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}";
}
try {
	echo ">>> доп плата по возрасту (10%)<br>";
	new BasicTariff(200, 120, 20, []);
} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}";
}
try {
	echo ">>> ограничение по возрасту<br>";
	new BasicTariff(200, 120, 100, []);
} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}";
}

echo "<hr> --- Студенческий --- <hr>";
try {
	echo ">>> доп плата по возрасту (10%)<br>";
	new StudentTariff(200, 120, 20, []);
} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}";
}
try {
	echo ">>> ограничение по возрасту<br>";
	new StudentTariff(200, 120, 27, []);
} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}";
}
try {
	echo ">>> 2 допа, additionalDriver отбрасывается<br>";
	new StudentTariff(200, 120, 25, ['gps', 'additionalDriver']);
} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}";
}

echo "<hr> --- Почасовой --- <hr>";
try {
	echo ">>> 50 мин - округление до часа<br>";
	new HourlyTariff(100, 50, 30, []);
} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}";
}
try {
	echo ">>> 50 мин - округление до часа + 2 допа, gps отбрасывается<br>";
	new HourlyTariff(100, 50, 30, ['gps', 'additionalDriver']);
} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}";
}
try {
	echo ">>> 2 часа + 2 допа<br>";
	new HourlyTariff(200, 120, 30, ['gps', 'additionalDriver']);
} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}";
}

echo "<hr> --- Суточный --- <hr>";
try {
	echo ">>> 23:50 мин - округление до дня<br>";
	new DailyTariff(2400, 24 * 60 - 10, 30, []);
} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}";
}
try {
	echo ">>> 24:10 мин - сброс до дня<br>";
	new DailyTariff(2400, 24 * 60 + 10, 30, []);
} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}";
}
try {
	echo ">>> 24:50 мин - округление до 2х дней<br>";
	new DailyTariff(2400, 24 * 60 + 50, 30, []);
} catch (Throwable $e) {
	echo "Error: {$e->getMessage()}";
}
