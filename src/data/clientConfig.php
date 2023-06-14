<?php

return [
	[
		'label' => 'Основное',
		'description' => '',
		'items' => [
			['key' => 'policy', 'xtype' => 'modx-panel-tv-file', 'label' => 'Политика конфиденциальности', 'value' => '#'],
			['key' => 'year_start', 'xtype' => 'numberfield', 'label' => 'Год начала в копирайте', 'value' => date('Y')],
			['key' => 'emailto', 'xtype' => 'textfield', 'label' => 'E-mail для заявок', 'value' => ''],
		],
	],
	[
		'label' => 'Контактная информация',
		'description' => '',
		'items' => [
			['key' => 'address', 'xtype' => 'textfield', 'label' => 'Адрес', 'value' => ''],
			['key' => 'phone', 'xtype' => 'textfield', 'label' => 'Телефон', 'value' => ''],
			['key' => 'email', 'xtype' => 'textfield', 'label' => 'E-mail', 'value' => ''],
		],
	],
	[
		'label' => 'SEO',
		'description' => '',
		'items' => [
			['key' => 'metrika_head', 'xtype' => 'textarea', 'label' => 'Метрика HEAD', 'value' => ''],
			['key' => 'metrika_body', 'xtype' => 'textarea', 'label' => 'Метрика BODY', 'value' => ''],
		],
	],
];
