<?php
/** @var modX $modx */
switch ($modx->event->name) {
	case 'pdoToolsOnFenomInit':
		$fenom->addModifier('ignore', function ($input) {
			$output = '{ignore}' . $input . '{/ignore}';
			return $output;
		});
		break;
}
