<?php
switch ($modx->event->name) {
	case 'OnMODXInit':
		$file = MODX_CORE_PATH . 'vendor/autoload.php';

		if (file_exists($file)) {
			require_once $file;
		}
		break;
}
