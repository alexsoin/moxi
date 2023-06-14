<?php
namespace App\Controllers;
use Zoomx\Controllers;

class HelloController extends \Zoomx\Controllers\Controller {
	public function hello() {
		zoomx()->autoloadResource(false);

		$site_name = $this->modx->getObject('modSystemSetting', ['key' => 'site_name']);
		return "hello {$site_name->get('value')}!";
	}
}
