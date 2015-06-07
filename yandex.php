<?php

use Tygh\Registry;
use Tygh\Ym\CronYml;

define('AREA', 'C');
define('NO_SESSION', true);
define('DEVELOPMENT', true);

@ini_set('display_errors', 'On');
error_reporting(E_ALL);

require dirname(__FILE__) . '/../init.php';

$company_id = Registry::get('runtime.company_id');

$options = Registry::get('addons.yandex_market');

$page = 0;

$lang_code = DESCR_SL;
if (Registry::isExist('languages.ru')) {
    $lang_code = 'ru';
}

$yml = new CronYml($company_id, $options, $lang_code, $page, true);

$filename = $yml->get();

fn_echo($filename);

exit;
