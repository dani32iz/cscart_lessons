<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($mode == 'list') {

    $cities = 'cities';

    Registry::get('view')->assign('cities', $cities);

}
