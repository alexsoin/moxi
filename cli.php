<?php
if (PHP_SAPI !== 'cli') {
	die("Этот скрипт можно запустить только из командной строки.");
}

require_once "./app.php";

$phpCheck = MoxiHelp::checkPHP();
if(!$phpCheck["success"]) {
	die("\n{$phpCheck["message"]}\n\n");
}

class MoxiCLI extends MoxiPack
{
	public function __construct($login, $password)
	{
		parent::__construct($login, $password);

		echo "\n------\n\n";

		$checkModx = $this->checkModx();

		if(!$checkModx["success"]) {
			$this->log($checkModx["message"], "error");
			die;
		}

		if ($this->isAdmin !== true) {
			$this->log("Вы ввели неверный логин или пароль, либо пользователь $login не является администратором", "error");
			die;
		}

		$title = MoxiHelp::prompt("Введите название сайта: ");
		$this->setSiteName($title);

		$newNameManager = MoxiHelp::prompt("Введите название пути панели управления: ");
		$this->setManagerName($newNameManager);

		$stepsNames = join(", ", array_column($this->steps, "name"));
		$this->log("Будут запущены следующие процессы: $stepsNames", "warning");

		$isInit = MoxiHelp::prompt("Вы уверены что хотите продолжить?[Y/n]: ");

		if(strtolower($isInit) === "y" || $isInit === "") {
			$this->init();
			$this->log("\nНастройка завершена!\n");
		} else {
			$this->clearCache();
			$this->log("Настройка отменена!");
		}

		$isRemoveApp = MoxiHelp::prompt("Удалить папку zenpack?[Y/n]: ");

		if(strtolower($isRemoveApp) === "y" || $isRemoveApp === "") {
			$this->removeApp();
		} else {
			$this->log("Moxi не удалён!");
			$this->log("Не рекомендуется оставлять пакет настройки Moxi в открытом доступе на сайте после установке. Удалите папке zenpack самостоятельно!", "warning");
		}
	}

	protected function init()
	{
		foreach ($this->steps as $step) {
			echo "\n=== {$step['desc']}\n";
			$this->call($step["name"]);
			echo "===\n";
		}
	}

	protected function log($message, $type = "info")
	{
		$types = [
			"info" => [ "color" => "blue", "desc" => "" ],
			"error" => [ "color" => "red", "desc" => "ОШИБКА!!!" ],
			"warning" => [ "color" => "yellow", "desc" => "ВНИМАНИЕ!!!" ],
		];
		$typeNow = $types[$type] ?: $types["info"];
		echo MoxiHelp::colorize("==={$typeNow['desc']}===\n$message\n======\n", $typeNow["color"]);
	}
}

echo MoxiHelp::colorize("

┌────────────────────────────────┐
│ ███╗░░░███╗░█████╗░██╗░░██╗██╗ │
│ ████╗░████║██╔══██╗╚██╗██╔╝██║ │
│ ██╔████╔██║██║░░██║░╚███╔╝░██║ │
│ ██║╚██╔╝██║██║░░██║░██╔██╗░██║ │
│ ██║░╚═╝░██║╚█████╔╝██╔╝╚██╗██║ │
│ ╚═╝░░░░░╚═╝░╚════╝░╚═╝░░╚═╝╚═╝ │
└────────────────────────────────┘

", "light_green");

$login = MoxiHelp::prompt("Введите логин: ");
$password = MoxiHelp::prompt("Введите пароль: ", true);

new MoxiCLI($login, $password);
