<?php

return [
	[
		'name' => 'img',
		'type' => 'mixedimage',
		'caption'  => 'Изображение',
		'category' => 0,
		'input_properties' => [
			'path' => 'assets/images/{d}-{m}-{y}/',
			'prefix' => '{rand}-',
			'MIME' => '',
			'showValue' => false,
			'showPreview' => true,
		],
	],
];
