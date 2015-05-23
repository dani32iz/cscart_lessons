<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($mode == 'list') {

    $addon_settings = Registry::get('addons.city');

    list($cities, $search) = fn_get_cities();

    $counts = count($cities) / $addon_settings['columns_count'];

    $cities_qroups = array_chunk($cities, round($counts));

    Registry::get('view')->assign('cities_qroups', $cities_qroups);

}
