<?php

use Tygh\Registry;
use Tygh\Ym\Yml;

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

$yml = new Yml($company_id, $options, $lang_code, $page, false);

$filename = $yml->getFileName();

$yml->generate($filename);

fn_echo('Good');

exit;
