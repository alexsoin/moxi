<?php
$filepath = MODX_BASE_PATH . $input;
if (file_exists($filepath)) {
	return $input . '?v=' . date('dmYHis', filemtime($filepath));
}
