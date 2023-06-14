<?php
require_once "./app.php";
header('Content-Type: application/json; charset=utf-8');

class MoxiWEB extends MoxiPack
{
	public function __construct()
	{
		parent::__construct();
		$checkModx = $this->checkModx();

		if(!$checkModx["success"]) {
			$this->res(false, null, $checkModx["message"]);
		}

		if(!$this->isAdmin) {
			$this->res(false, null, "Авторизуйтесь в панели управления");
		}

		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$this->res(true, [ "params" => $this->data, "steps" => $this->steps ]);
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$requestBody = file_get_contents('php://input');
			$data = json_decode($requestBody, true);

			if ($data === null) {
				$this->res(false, null, "Ошибка неверный запрос");
			}

			$step = trim($data['step']);
			$items = is_string($data['items']) ? trim($data['items']) : $data['items'];

			if (empty($step)) {
				$this->res(false, null, "Ошибка некорректные данных");
			}

			$this->call($step, $items);
			$this->res(true, null, null, $this->logs);
		}
	}

	/**
	 * Метод для формирования ответа
	 *
	 * @param bool $isSuccess Успешность выполнения операции
	 * @param array|null $data Данные для передачи в ответе
	 * @param string|null $message Сообщение для передачи в ответе
	 * @param array|null $log Журнал операций для передачи в ответе
	 */
	static function res(bool $isSuccess, array $data = null, String $message = null, array $log = null)
	{
		$out = [ "success" => $isSuccess ];

		if($data) { $out["data"] = $data; }
		if($message) { $out["message"] = $message; }
		if($log) { $out["log"] = $log; }

		die(json_encode($out));
	}
}

$phpCheck = MoxiHelp::checkPHP();
if(!$phpCheck["success"]) {
	MoxiWEB::res(false, null, $phpCheck["message"]);
}

new MoxiWEB;
