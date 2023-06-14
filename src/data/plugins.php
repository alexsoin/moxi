<?php

return [
	'ignore' => [
		'name' => 'ignore',
		'description' => 'Обертывание выводимых данных в тег ignore',
		'events' => [
			'pdoToolsOnFenomInit' => []
		]
	],
	'composer_init' => [
		'name' => 'composer_init',
		'description' => 'Инициализация composer',
		'events' => [
			'OnMODXInit' => []
		]
	],
	'template_list' => [
		'name' => 'template_list',
		'description' => 'Добавляет кнопку показа ссылок на файловые шаблоны',
		'events' => [
			'OnTempFormPrerender' => []
		]
	],
	'manager_breadcrumbs' => [
		'name' => 'manager_breadcrumbs',
		'description' => 'Хлебные крошки в админке',
		'events' => [
			'OnDocFormPrerender' => []
		]
	],
];
