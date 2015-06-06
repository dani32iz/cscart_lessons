#!/usr/bin/php
<?php

// Подключаем классы ядра
use Tygh\Registry;
use Tygh\Ym\Yml;

// Константы
define('AREA', 'C');
define('NO_SESSION', true);
define('YANDEX_CRON_PRINT_RESULT', false);

// Отображение ошибок
@ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Подключаем ядро
require dirname(__FILE__) . '/../init.php';

// Получаем ID витрины
$company_id = Registry::get('runtime.company_id');

// Настройки модуля Яндекс.Маркет
$options = Registry::get('addons.yandex_market');

$page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : 0;

$lang_code = DESCR_SL;

if (Registry::isExist('languages.ru')) {
    $lang_code = 'ru';
}

$yml = new Yml($company_id, $options, $lang_code, $page, true);

$filename = $yml->getFileName();

$yml->generate($filename);

exit;
