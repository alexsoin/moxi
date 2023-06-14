<?php
/*
┌────────────────────────────────┐
│ ███╗░░░███╗░█████╗░██╗░░██╗██╗ │
│ ████╗░████║██╔══██╗╚██╗██╔╝██║ │
│ ██╔████╔██║██║░░██║░╚███╔╝░██║ │
│ ██║╚██╔╝██║██║░░██║░██╔██╗░██║ │
│ ██║░╚═╝░██║╚█████╔╝██╔╝╚██╗██║ │
│ ╚═╝░░░░░╚═╝░╚════╝░╚═╝░░╚═╝╚═╝ │
└────────────────────────────────┘
────────────────────────────────────────────────────
author: Alex Soin                 https://zencod.ru/
────────────────────────────────────────────────────
*/

/**
 * Class MoxiHelp
 *
 * Вспомогательный класс
 */
class MoxiHelp
{
	/**
	 * Добавляет цвет к тексту для вывода в консоль.
	 *
	 * @param string $text Текст, который нужно окрасить.
	 * @param string $color Цвет текста (например, 'green', 'red', 'blue' и т. д.).
	 * @return string Окрашенный текст.
	 */
	static function colorize($text, $color)
	{
		$colors = [
			'black'        => '0;30',
			'dark_gray'    => '1;30',
			'blue'         => '0;34',
			'light_blue'   => '1;34',
			'green'        => '0;32',
			'light_green'  => '1;32',
			'cyan'         => '0;36',
			'light_cyan'   => '1;36',
			'red'          => '0;31',
			'light_red'    => '1;31',
			'purple'       => '0;35',
			'light_purple' => '1;35',
			'brown'        => '0;33',
			'yellow'       => '1;33',
			'light_gray'   => '0;37',
			'white'        => '1;37',
		];
		if (isset($colors[$color])) {
			return "\033[" . $colors[$color] . "m" . $text . "\033[0m";
		} else {
			return $text;
		}
	}

	/**
	 * Выводит сообщение в консоль и ожидает ввода пользователя.
	 *
	 * @param string $message Сообщение для вывода.
	 * @param bool $isPassword Если true, скрывает ввод (полезно для ввода паролей).
	 * @return string Введенный пользователем текст.
	 */
	static function prompt($message, $isPassword = false)
	{
		echo MoxiHelp::colorize($message, "green");

		if($isPassword) {
			system('stty -echo');
			$password = trim(fgets(STDIN));
			system('stty echo');
			echo PHP_EOL;
			return $password;
		}

		return trim(fgets(STDIN));
	}

	/**
	 * Возвращает массив порядка выполнения операций.
	 *
	 * @return array Массив порядка выполнения операций, включает в себе имя и описание.
	 */
	static function steps()
	{
		return [
			["name" => "providers", "desc" => "Добавление поставщиков дополнений", ],
			["name" => "addons", "desc" => "Установка дополнений", ],
			["name" => "copyCore", "desc" => "Копирование папки core", ],
			["name" => "templates", "desc" => "Добавление шаблонов", ],
			["name" => "resources", "desc" => "Добавление ресурсов", ],
			["name" => "settings", "desc" => "Изменение настроек", ],
			["name" => "snippets", "desc" => "Добавление сниппетов", ],
			["name" => "plugins", "desc" => "Добавление плагинов", ],
			["name" => "tvs", "desc" => "Добавление дополнительных полей", ],
			["name" => "clientConfig", "desc" => "Настройка clientConfig", ],
			["name" => "managerCustomize", "desc" => "Настройка панели администрирования", ],
			["name" => "renameHtaccess", "desc" => "Переименовывание ht.access в .htaccess", ],
			["name" => "removeChangelog", "desc" => "Удаление changelog", ],
			["name" => "clearCache", "desc" => "Очистка кэша", ],
		];
	}

	/**
	 * Проверяет, является ли текущая версия PHP равной или выше требуемой минимальной версии
	 *
	 * @return array Возвращает ассоциативный массив с ключом "success", указывающим на успешность проверки, и опциональным ключом "message" для предоставления дополнительной информации в случае неудачи.
	 */
	static function checkPHP()
	{
		$v_php_now = phpversion();
		$v_php_min = 7.4;

		if($v_php_now < $v_php_min) {
			return [ "success" => false, "message" => "Вы запустили скрипт с php версией $v_php_now. Минимальная версия php для запуска $v_php_min" ];
		}

		return [ "success" => true ];
	}
}

/**
 * Class MoxiModx
 *
 * Класс для работы с MODX.
 */
class MoxiModx
{
	public $modx;
	public $path = [];

	/**
	 * Конструктор класса MoxiModx.
	 *
	 * Инициализирует объект modX и подключает необходимые файлы.
	 */
	public function __construct() {
		$this->path["site"] = dirname(dirname(__FILE__)) . '/';
		require_once $this->path["site"] . 'config.core.php';
		require_once $this->path["site"] .'core/model/modx/modx.class.php';

		/** @var modX $this->modx */
		$this->modx = new modX();
		$this->modx->initialize('mgr');
		$this->modx->getService('error', 'error.modError');
	}

	/**
	 * Проверяет, является ли пользователь администратором. Если логин и пароль не переданны, то проверяется авторизация в текущей сессии
	 *
	 * @param string|null $username Логин администратора сайта.
	 * @param string|null $password Пароль администратора сайта.
	 * @return bool Возвращает true, если пользователь является администратором, иначе false.
	 */
	public function checkAdmin($username = null, $password = null)
	{
		if($username) {
			$user = $this->modx->getObject('modUser', ['username' => $username]);

			if ($user && $user->passwordMatches($password)) {
				if ($user->get('sudo') == 1 || $user->isMember('Administrator')) {
					return true;
				} else {
					// return 'Пользователь не является администратором';
					return false;
				}
			} else {
				// return 'Неверный логин или пароль';
				return false;
			}
		} else {
			$user = $this->modx->getUser();

			return $user && $user->hasSessionContext('mgr') && $user->isMember('Administrator');
		}
	}

	/**
	 * Проверяет установленную версию MODX на соответствие допустимому диапазону версий.
	 *
	 * @return array Возвращает ассоциативный массив с ключом "success", указывающим на успешность проверки, и опциональным ключом "message" для предоставления дополнительной информации в случае неудачи.
	 */
	public function checkModx()
	{
		$v_modx_now = $this->modx->getOption('settings_version');
		$v_modx_min = 2.7;
		$v_modx_max = 3;

		if($v_modx_now < $v_modx_min || $v_modx_now >= $v_modx_max) {
			return [ "success" => false, "message" => "Установлен modx версии $v_modx_now. Поддерживаются версии modx с $v_modx_minдо $v_modx_max" ];
		}

		return [ "success" => true ];
	}
}

/**
 * Class MoxiPack
 *
 * Основной класс.
 */
class MoxiPack extends MoxiModx
{
	/** @var string $mode Текущий режим работы */
	private $mode = PHP_SAPI;

	/** @var array $data Массив данных, которые берутся из файлов в директории src/data */
	public $data = [];

	/** @var array $steps Порядок выполнения операций */
	public $steps = [];

	/** @var array $logs Лог сообщений */
	public $logs = [ "info" => [], "error" => [], "warning" => [], ];

	/**
	 * Конструктор класса MoxiPack.
	 *
	 * @param string|null $username Логин администратора сайта
	 * @param string|null $password Пароль администратора сайта
	 */
	public function __construct($username = null, $password = null)
	{
		parent::__construct();
		$this->isAdmin = $this->checkAdmin($username, $password);

		if($this->isAdmin !== true) {
			return;
		}

		$this->setData();
	}

	/**
	 * Устанавливает начальные данные
	 */
	protected function setData()
	{
		$this->path["app"] = dirname(__FILE__) . '/';
		$this->path["src"]["root"] = $this->path["app"] . "src/";
		$this->path["src"]["data"] = $this->path["src"]["root"] . "data/";
		$this->path["src"]["content"] = $this->path["src"]["root"] . "content/";
		$this->path["src"]["pages"] = $this->path["src"]["content"] . "pages/";
		$this->path["src"]["snippets"] = $this->path["src"]["content"] . "snippets/";
		$this->path["src"]["plugins"] = $this->path["src"]["content"] . "plugins/";
		$this->path["src"]["templates"] = $this->path["src"]["content"] . "templates/";
		$this->steps = MoxiHelp::steps();

		if (is_dir($this->path["src"]["data"])) {
			$files = scandir($this->path["src"]["data"]);

			foreach ($files as $file) {
				if ($file != '.' && $file != '..') {
					$filename = pathinfo($file, PATHINFO_FILENAME);
					$this->data[$filename] = include($this->path["src"]["data"] . $file);
				}
			}
		}
	}

	/**
	 * Устанавливает название сайта
	 *
	 * @param string $site_name Название сайта
	 * @return bool
	 */
	public function setSiteName($site_name)
	{
		if(mb_strlen($site_name) === 0) {
			$this->log("Название сайта не изменено");
			return false;
		}

		$setting = $this->modx->getObject('modSystemSetting', ['key' => 'site_name']);
		$setting->set('value', $site_name);
		$setting->save();

		$this->log("Название сайта изменено");
		return true;
	}

	/**
	 * Устанавливает путь к панели управления
	 *
	 * @param string $site_name Путь к панели управления
	 * @return bool
	 */
	public function setManagerName($newNameManager)
	{
		if(mb_strlen($newNameManager) === 0) {
			$this->log("Название сайта не изменено");
			return false;
		}

		$managerPath = $this->modx->getOption("manager_path");
		$basePath = $this->modx->getOption("base_path");
		$corePath = $this->modx->getOption("core_path");
		$itemsRoot = scandir($basePath);
		$managerUri = str_replace($basePath, "", $managerPath);
		$managerUriNew = "$newNameManager/";
		$configFilePath = $corePath."config/config.inc.php";
		$managerPathNew = str_replace($managerUri, $managerUriNew, $managerPath);

		if(in_array($newNameManager, $itemsRoot)) {
			$this->log("Нельзя переименовать панель управления. Данная директория занята.", "error");
			return false;
		}

		if(!file_exists($configFilePath)) {
			$this->log("Файл конфига не найден", "error");
			return false;
		}

		if (!is_dir($managerPath)) {
			$this->log("Не найдена папка панели управления", "error");
			return false;
		}

		$configFileContent = file_get_contents($configFilePath);
		$configFileContentNew = str_replace($managerUri, $managerUriNew, $configFileContent);

		file_put_contents($configFilePath, $configFileContentNew);

		$this->log("Пути к панели управления в config.inc.php успешно изменены");

		if (rename($managerPath, $managerPathNew)) {
			$this->log("Папка успешно переименована");
		} else {
			$this->log("Не удалось переименовать папку", "error");
		}

		$this->log("Расположение папки панели управления успешно изменено");
		return true;
	}

	/**
	 * Вызывает метод класса
	 *
	 * @param string $functionName Имя метода
	 * @param mixed $args Аргументы
	 * @return mixed
	 */
	public function call($functionName, $args = null)
	{
		if (is_callable([$this, $functionName])) {
			return $this->$functionName($args);
		} else {
			$this->log("Функция с именем $functionName не существует в классе или не является публичной", "error");
		}
	}

	/**
	 * Копирует элементы директории src/core в папке core сайта
	 *
	 * @return void
	 */
	public function copyCore()
	{
		$dir_from = $this->path["src"]["content"] . "core/";
		$dir_to = $this->modx->getOption('core_path');

		if(!is_dir($dir_from)) {
			$this->log("Папка '$dir_from' не найдена", "error");
			return;
		}

		if(!is_dir($dir_to)) {
			$this->log("Папка '$dir_to' не найдена", "error");
			return;
		}

		$this->modx->cacheManager->copyTree($this->path["src"]["content"] . "core/", $this->modx->getOption('core_path'));
		$this->log("Элементы директории core скопированы");
	}

	/**
	 * Добавляет ресурсы
	 *
	 * @param array|null $resources Массив ресурсов, которые нужно добавить
	 *
	 * @return void
	 */
	public function resources($resources = null)
	{
		$resources = $resources ?: $this->data["resources"];
		/** @noinspection PhpIncludeInspection */
		if (!is_array($this->data["resources"])) {
			$this->log("Массив ресурсов пуст", "error");
			return;
		}

		foreach ($resources as $context => $items) {
			$menuindex = 0;
			foreach ($items as $alias => $item) {
				$item['alias'] = $alias;
				$item['context_key'] = $context;
				$item['menuindex'] = $menuindex++;
				$this->_addResource($item, $alias);
			}
		}
	}

	/**
	 * Добавляет провайдеров дополнений
	 *
	 * @param array|null $providers Массив провайдеров, которые нужно добавить
	 *
	 * @return void
	 */
	public function providers($providers = null)
	{
		$providers = $providers ?: $this->data["providers"];
		if (!is_array($providers)) {
			$this->log("Массив провайдеров пуст", "error");
			return;
		}

		foreach ($providers as $properties) {
			if ($this->modx->getObject('transport.modTransportProvider', ['service_url:LIKE' => '%' . $properties["name"] . '%'])) {
				$this->log("Провайдер '{$properties['name']}' уже существует", "warning");
				continue;
			}

			$provider = $this->modx->newObject('transport.modTransportProvider', $properties);
			$provider->save();
			$this->log("Провайдер '{$properties['name']}' успешно добавлен");
		}
	}

	/**
	 * Добавляет дополнения
	 *
	 * @param array|null $addons Массив дополнений, которые нужно добавить
	 *
	 * @return void
	 */
	public function addons($addons = null)
	{
		$addons = $addons ?: $this->data["addons"];
		if (!is_array($addons)) {
			$this->log("Массив дополнений пуст", "error");
			return;
		}

		foreach ($addons as $provider => $packages) {
			foreach ($packages as $package) {
				$this->_installPackage($package, $provider);
			}
		}
	}

	/**
	 * Изменяет системные настройки
	 *
	 * @param array|null $settings Массив настроек, которые нужно изменить
	 *
	 * @return void
	 */
	public function settings($settings = null)
	{
		$settings = $settings ?: $this->data["settings"];
		if (!is_array($settings)) {
			$settings = [];
		}

		$errors_pages = [
			'401' => 'unauthorized_page',
			'404' => 'error_page',
			'503' => 'site_unavailable_page'
		];

		foreach($errors_pages as $uri_page => $system_setting) {
			if($res = $this->modx->getObject('modResource', ['uri' => $uri_page]) ) {
				$settings[$system_setting] = $res->get('id');
			}
		}

		foreach ($settings as $key => $value) {
			if ($option = $this->modx->getObject('modSystemSetting', $key)) {
				$option->set('value', $value);
				$option->save();
			}
		}

		if ($contentType = $this->modx->getObject('modContentType', ['name' => 'HTML'])) {
			$contentType->set('headers', [
				'X-Frame-Options:deny',
				'X-XSS-Protection:1;mode=block',
				'X-Content-Type-Options:nosniff',
				'Referrer-Policy:no-referrer',
				'Cache-Control: max-age=31536000, must-revalidate'
			]);
			$contentType->set('name', 'WEB');
			$contentType->set('file_extensions', '');
			$contentType->save();
		}

		$this->log("Изменение системных настроек завершено");
	}

	/**
	 * Добавляет сниппеты
	 *
	 * @param array|null $snippets Массив сниппетов, которые нужно добавить
	 *
	 * @return void
	 */
	public function snippets($snippets = null)
	{
		$snippets = $snippets ?: $this->data["snippets"];

		if (!is_array($snippets)) {
			$this->log("Массив сниппетов пуст", "error");
			return;
		}

		foreach ($snippets as $filename => $data) {
			if(!file_exists($this->path["src"]["snippets"] . $filename . '.php')) {
				$this->log("Сниппет '$filename' не найден", "error");
				continue;
			}

			if($this->modx->getObject('modSnippet', ['name' => $data['name']])) {
				$this->log("Сниппет '$filename' уже существует", "warning");
				continue;
			}

			/** @var modSnippet[] $objects */
			$newSnippet = $this->modx->newObject('modSnippet');
			$newSnippet->fromArray(array_merge([
				'name' => $data['name'],
				'description' => @$data['description'],
				'snippet' => $this::_getContent($this->path["src"]["snippets"] . $filename . '.php'),
			], $data), '', true, true);
			$newSnippet->save();
			$this->log("Сниппет $filename успешно создан");
		}
	}

	/**
	 * Добавляет плагины
	 *
	 * @param array|null $plugins Массив плагинов, которые нужно добавить
	 *
	 * @return void
	 */
	public function plugins($plugins = null)
	{
		/** @noinspection PhpIncludeInspection */
		$plugins = $plugins ?: $this->data["plugins"];
		if (!is_array($plugins)) {
			$this->log("Массив плагинов пуст", "error");
			return;
		}

		foreach ($plugins as $filename => $data) {
			if(!file_exists($this->path["src"]["plugins"] . $filename . '.php')) {
				$this->log("Плагин '$filename' не найден", "error");
				continue;
			}

			if($this->modx->getObject('modPlugin', ['name' => $data['name']])) {
				$this->log("Плагин '$filename' уже существует", "warning");
				continue;
			}

			/** @var modPlugin $plugin */
			$plugin = $this->modx->newObject('modPlugin');
			$plugin->fromArray(array_merge([
				'name' => $data["name"],
				'description' => @$data['description'],
				'plugincode' => $this::_getContent($this->path["src"]["plugins"] . $filename . '.php'),
			], $data), '', true, true);

			$events = [];
			if (!empty($data['events'])) {
				foreach ($data['events'] as $event_name => $event_data) {
					/** @var modPluginEvent $event */
					$event = $this->modx->newObject('modPluginEvent');
					$event->fromArray(array_merge([
						'event' => $event_name,
						'priority' => 0,
						'propertyset' => 0,
					], $event_data), '', true, true);
					$events[] = $event;
				}
			}
			if (!empty($events)) {
				$plugin->addMany($events);
			}
			$plugin->save();

			$this->log("Плагин $filename успешно создан");
		}
	}

	/**
	 * Создает шаблоны
	 *
	 * @param array|null $templates Массив шаблонов.
	 * @return void
	 */
	public function templates($templates = null)
	{
		$indexTemplate = $this->modx->getObject('modTemplate', 1);
		$indexTemplate->fromArray([
			'templatename' => 'Главная страница',
			'description' => '',
			'content' => "{include 'file:templates/index.tpl'}",
		]);
		$indexTemplate->save();

		/** @noinspection PhpIncludeInspection */
		$templates = $templates ?: $this->data["templates"];

		if (!is_array($templates)) {
			$this->log("Массив шаблонов пуст", "error");
			return;
		}

		foreach ($templates as $filename => $data) {
			if($this->modx->getObject('modTemplate', ['templatename' => $data['name']])) {
				$this->log("Шаблон '$filename' уже существует", "warning");
				continue;
			}
			/** @var modTemplate[] $objects */
			$newTemplate = $this->modx->newObject('modTemplate');
			$newTemplate->fromArray(array_merge([
				'templatename' => $data['name'],
				'description' => $data['description'],
				'content' => $this::_getContent($this->path["src"]["templates"] . $filename . '.tpl'),
			], $data), '', true, true);

			$newTemplate->save();

			$this->log("Шаблон '$filename' успешно создан");
		}
	}

	/**
	 * Создает TV-параметры
	 *
	 * @param array|null $tvs Массив TV-параметров.
	 * @return void
	 */
	public function tvs($tvs = null)
	{
		$tvs = $tvs ?: $this->data["tvs"];
		if (!is_array($tvs)) {
			$this->log("Массив тивишек пуст", "error");
			return;
		}

		$addeds = [];
		foreach ($tvs as $data) {
			if($tv = $this->modx->getObject('modTemplateVar', ['name' => $data['name']])) {
				$this->log("ТВ '{$data['name']}' уже существует", "warning");
				continue;
			}

			$tv = $this->modx->newObject('modTemplateVar');
			$tv->fromArray($data);
			$tv->save();

			$this->log("ТВ '{$data['name']}' успешно создан");

			$addeds[] = $tv->get('id');
		}

		foreach ($this->modx->getCollection('modTemplate') as $template) {
			$templateId = $template->id;
			foreach ($addeds as $k => $tvid) {
				if (!$tvt = $this->modx->getObject('modTemplateVarTemplate', ['tmplvarid' => $tvid, 'templateid' => $templateId])) {
					$record = ['tmplvarid' => $tvid, 'templateid' => $templateId];
					$keys = array_keys($record);
					$fields = '`' . implode('`,`', $keys) . '`';
					$placeholders = substr(str_repeat('?,', count($keys)), 0, -1);
					$sql = "INSERT INTO {$this->modx->getTableName('modTemplateVarTemplate')} ({$fields}) VALUES ({$placeholders});";
					$this->modx->prepare($sql)->execute(array_values($record));
				}
			}
		}
	}

	/**
	 * Настраивает дополнение clientConfig
	 *
	 * @return void
	 */
	public function clientConfig()
	{
		$path = $this->modx->getOption('clientconfig.core_path', null, $this->modx->getOption('core_path') . 'components/clientconfig/');
		$path .= 'model/clientconfig/';
		$clientConfig = $this->modx->getService('clientconfig','ClientConfig', $path);

		if ($clientConfig instanceof ClientConfig && is_array($this->data["clientConfig"])) {
			foreach ($this->data["clientConfig"] as $ccGroupKey => $ccGroup) {
				if(!$group = $this->modx->getObject('cgGroup', [ 'label' => $ccGroup['label'] ])) {
					$group = $this->modx->newObject('cgGroup');
					$group->set('label', $ccGroup['label']);
					$group->set('description', $ccGroup['description']);
					$group->set('sortorder', $ccGroupKey);
					$group->save();
				}

				foreach ($ccGroup['items'] as $idx => $data) {
					if(!$setting = $this->modx->getObject('cgSetting', [ 'key' => $data['key'] ])) {
						$setting = $this->modx->newObject('cgSetting');
						$setting->fromArray(array_merge([
							'description' => '',
							'xtype' => 'textfield',
							'sortorder' => $idx,
							'group' => $group->id,
						], $data), '', true, true);
						$setting->save();
					}
				}
			}

			if ($menu = $this->modx->getObject('modMenu', ['namespace' => 'clientconfig', 'action' => 'home'])) {
				if ($menu->get('parent') != 'topnav') {
					$data = $menu->toArray();
					$data['previous_text'] = $menu->get('text');
					$data['text'] = 'Конфигурация';
					$data['parent'] = 'topnav';
					$data['description'] = '';
					$data['icon'] = '';
					$data['menuindex'] = 99;
					$data['action_id'] = $data['action'];
					$response = $this->modx->runProcessor('system/menu/update', $data);
				}
			}
			$this->log("clientConfig успешно настроен");
		} else {
			$this->log("Не найден clientConfig", "warning");
		}
	}

	/**
	 * Настраивает панель управления.
	 *
	 * @return void
	 */
	public function managerCustomize()
	{
		if (!$profile = $this->modx->getObject('modFormCustomizationProfile', ['name' => 'Site'])) {
			$profile = $this->modx->newObject('modFormCustomizationProfile', ['name' => 'Site', 'active' => true]);
			$profile->save();
		}
		$set = ['profile' => $profile->id];
		$set_list = [];
		if (!$set_list['create_set'] = $this->modx->getObject('modFormCustomizationSet', array_merge(['action' => 'resource/create'], $set))) {
			$description = 'Правила для новых страниц';
			$set_list['create_set'] = $this->modx->newObject('modFormCustomizationSet', array_merge(['action' => 'resource/create', 'description' => $description, 'active' => true], $set));
			$set_list['create_set']->save();
		}
		if (!$set_list['update_set'] = $this->modx->getObject('modFormCustomizationSet', array_merge(['action' => 'resource/update'], $set))) {
			$description = 'Правила для редактирования';
			$set_list['update_set'] = $this->modx->newObject('modFormCustomizationSet', array_merge(['action' => 'resource/update', 'description' => $description, 'active' => true], $set));
			$set_list['update_set']->save();
		}

		if ($tv = $this->modx->getObject('modTemplateVar', ['name' => 'img'])) {
			foreach ($set_list as $set) {
				$rule_data = [
					'set' => $set->id,
					'action' => $set->action,
					'name' => 'tv' . $tv->id,
					'container' => 'modx-panel-resource',
					'rule' => 'tvMove',
					'value' => 'modx-resource-main-right',
					'constraint_class' => 'modResource'
				];
				if (!$rule = $this->modx->getObject('modActionDom', $rule_data)) {
					$rule_data['active'] = true;
					$rule = $this->modx->newObject('modActionDom', $rule_data);
					$rule->save();
				}
			}
		}

		if ($this->modx->getObject('transport.modTransportPackage', [ 'package_name' => 'MIGX', 'installed:IS NOT' => null ])) {
			$set_list = [];
			$set = ['profile' => $profile->id];
			if (!$set_list['update_set'] = $this->modx->getObject('modFormCustomizationSet', array_merge(['action' => 'resource/update', 'constraint' => 0, 'constraint_field' => 'parent', 'constraint_class' => 'modResource'], $set))) {
				$description = 'Правила для страниц в корне сайта';
				$set_list['update_set'] = $this->modx->newObject('modFormCustomizationSet', array_merge(['action' => 'resource/update', 'constraint' => 0, 'constraint_field' => 'parent', 'constraint_class' => 'modResource', 'description' => $description, 'active' => true], $set));
				$set_list['update_set']->save();
			}
			if ($tv = $this->modx->getObject('modTemplateVar', ['name' => 'elements'])) {
				foreach ($set_list as $set) {
					$rule_data = [
						'set' => $set->id,
						'action' => $set->action,
						'name' => 'tv' . $tv->id,
						'container' => 'modx-panel-resource',
						'rule' => 'tvMove',
						'value' => 'modx-resource-main-left',
						'constraint_class' => 'modResource'
					];
					if (!$rule = $this->modx->getObject('modActionDom', $rule_data)) {
						$rule_data['active'] = true;
						$rule = $this->modx->newObject('modActionDom', $rule_data);
						$rule->save();
					}
				}
			}
		}

		$this->log("Настройка панели управления завершена");
	}

	/**
	 * Переименовывает файлы .ht.access в .htaccess
	 *
	 * @return void
	 */
	public function renameHtaccess()
	{
		$list = [
			$this->modx->getOption('base_path'),
			$this->modx->getOption('core_path'),
			$this->modx->getOption('manager_path'),
		];

		foreach ($list as $path) {
			if (file_exists($path . 'ht.access')) {
				rename($path . 'ht.access', $path . '.htaccess');
			}
		}

		$this->log(".htaccess переименован");
	}

	/**
	 * Удаляет файл changelog.txt
	 *
	 * @return void
	 */
	public function removeChangelog()
	{
		$file = $this->modx->getOption('core_path') . 'docs/changelog.txt';

		if (file_exists($file)) {
			unlink($file);
			$this->log("changelog.txt удален");
		} else {
			$this->log("changelog.txt не найден", "warning");
		}
	}

	/**
	 * Очищает кэш MODX.
	 *
	 * @return void
	 */
	public function clearCache()
	{
		$this->modx->cacheManager->refresh();

		$this->log("Кэш очищен");
	}

	/**
	 * Скачивает дополнение с заданного URL и сохраняет его на диск.
	 *
	 * @param string $src URL-адрес дополнения.
	 * @param string $dst Путь для сохранения дополнения.
	 * @return bool Возвращает true в случае успешного сохранения дополнения, иначе false.
	 */
	protected function _downloadPackage($src, $dst)
	{
		if (ini_get('allow_url_fopen')) {
			$file = @file_get_contents($src);
		}
		else if (function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $src);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT,180);
			$safeMode = @ini_get('safe_mode');
			$openBasedir = @ini_get('open_basedir');
			if (empty($safeMode) && empty($openBasedir)) {
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			}

			$file = curl_exec($ch);
			curl_close($ch);
		}
		else {
			return false;
		}
		file_put_contents($dst, $file);

		return file_exists($dst);
	}

	/**
	 * Устанавливает дополнение MODX.
	 *
	 * @param string $packageName Имя дополнения.
	 * @param string|null $provider_name Имя провайдера дополнения.
	 * @return bool Возвращает true в случае успешной установки дополнения, иначе false.
	 */
	protected function _installPackage($packageName, $provider_name)
	{
		if($installedPackage = $this->modx->getObject('transport.modTransportPackage', [ 'package_name' => $packageName, 'installed:IS NOT' => null ])) {
			$this->log("Дополнение '{$packageName}' уже было установлено", "warning");
			return;
		}

		if (!$provider_name || !$provider = $this->modx->getObject('transport.modTransportProvider', ['service_url:LIKE' => '%' . $provider_name . '%'])) {
			$provider = $this->modx->getObject('transport.modTransportProvider', 1);
		}

		$provider->getClient();
		$this->modx->getVersionData();
		$productVersion = $this->modx->version['code_name'].'-'.$this->modx->version['full_version'];

		$response = $provider->request('package','GET', [
			'supports' => $productVersion,
			'query' => $packageName
		]);

		if (!empty($response)) {

			$foundPackages = simplexml_load_string($response->response);

			foreach($foundPackages as $foundPackage) {
				/* @var modTransportPackage $foundPackage */
				if($foundPackage->name == $packageName) {
					$sig = explode('-',$foundPackage->signature);
					$versionSignature = explode('.',$sig[1]);
					$url = $foundPackage->location;

					if (!$this->_downloadPackage($url, $this->modx->getOption('core_path').'packages/'.$foundPackage->signature.'.transport.zip')) {
						$this->log("$packageName не удалось скачать", "error");
						return;
					}

					$package = $this->modx->newObject('transport.modTransportPackage');
					$package->set('signature',$foundPackage->signature);
					$package->fromArray([
						'created' => date('Y-m-d h:i:s'),
						'updated' => null,
						'state' => 1,
						'workspace' => 1,
						'provider' => $provider->id,
						'source' => $foundPackage->signature . '.transport.zip',
						'package_name' => $packageName,
						'version_major' => $versionSignature[0],
						'version_minor' => !empty($versionSignature[1]) ? $versionSignature[1] : 0,
						'version_patch' => !empty($versionSignature[2]) ? $versionSignature[2] : 0,
					]);

					if (!empty($sig[2])) {
						$r = preg_split('/([0-9]+)/',$sig[2],-1,PREG_SPLIT_DELIM_CAPTURE);

						if (is_array($r) && !empty($r)) {
							$package->set('release',$r[0]);
							$package->set('release_index',(isset($r[1]) ? $r[1] : '0'));
						} else {
							$package->set('release',$sig[2]);
						}
					}

					if ($package->save() && $package->install()) {
						$this->log("$packageName установлено");
						return;
					}
					else {
						$this->log("$packageName не удалось установить", "error");
						return;
					}
					break;
				}
			}
		}
		else {
			$this->log("$package не найдено", "error");
			return;
		}
		return true;
	}

	/**
	 * Возвращает содержимое файла.
	 *
	 * @param string $filename Путь к файлу.
	 * @return string Содержимое файла.
	 */
	static public function _getContent($filename)
	{
		if (file_exists($filename)) {
			$file = trim(file_get_contents($filename));

			return preg_match('#\<\?php(.*)#is', $file, $data)
					? rtrim(rtrim(trim(@$data[1]), '?>'))
					: $file;
		}

		return '';
	}

	/**
	 * Создает ресурс MODX.
	 *
	 * @param array $data Массив данных для создания ресурса.
	 * @param string $uri URI ресурса.
	 * @param int $parent ID родительского ресурса.
	 * @return void
	 */
	protected function _addResource(array $data, $uri, $parent = 0)
	{
		$file = $data['context_key'] . '/' . $uri;
		$content_path = $this->path["src"]["pages"] . "{$data['alias']}.tpl";

		$content = file_exists($content_path) ? file_get_contents($content_path) : '';

		if($resource = $this->modx->getObject('modResource', ['pagetitle' => $data["pagetitle"]]) ) {
			$this->log("Ресурс '{$data['pagetitle']}' уже существует", "warning");
		} else {
			/** @var modResource $resource */
			$resource = $this->modx->newObject('modResource');
			$resource->fromArray(array_merge([
				'parent' => $parent,
				'published' => true,
				'deleted' => false,
				'hidemenu' => false,
				'createdon' => time(),
				'isfolder' => !empty($data['isfolder']) || !empty($data['resources']),
				'uri' => $uri,
				'uri_override' => false,
				'searchable' => true,
				'content' => $content,
			], $data), '', true, true);

			$resource->save();

			$this->log("Ресурс '{$data['pagetitle']}' успешно создан. ID: $resource->id");

			if (!empty($data['groups'])) {
				foreach ($data['groups'] as $group) {
					$resource->joinGroup($group);
				}
			}
		}

		if (!empty($data['resources'])) {
			$menuindex = 0;
			foreach ($data['resources'] as $alias => $item) {
				$item['alias'] = $alias;
				$item['context_key'] = $data['context_key'];
				$this->_addResource($item, $uri . '/' . $alias, $resource->id);
			}
		}
	}

	/**
	 * Удаляет приложение Moxi
	 *
	 * @return void
	 */
	public function removeApp()
	{
		$cacheManager = $this->modx->getCacheManager();

		if ($cacheManager && $cacheManager->deleteTree($this->path["app"],true,false,false)) {
			$this->log("Moxi успешно удалён");
		} else {
			$this->log("Не удалось удалить Moxi", "error");
		}
	}

	/**
	 * Логирует сообщения в консоль или массив логов.
	 *
	 * @param string $message Текст сообщения.
	 * @param string $type Тип сообщения (info, error, warning).
	 * @return void
	 */
	protected function log($message, $level = "info")
	{
		$types = [
			"info" => [ "color" => "blue", "desc" => "" ],
			"error" => [ "color" => "red", "desc" => "ОШИБКА!!!" ],
			"warning" => [ "color" => "yellow", "desc" => "ВНИМАНИЕ!!!" ],
		];
		$typeNow = $types[$type] ?: $types["info"];

		$this->logs[$level][] = $message;

		if($this->mode === "cli") {
			echo MoxiHelp::colorize("{$message}\n", $typeNow["color"]);
		}
	}
}
