<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($mode == 'shipping_rates') {

    if (isset($_REQUEST['product']) && !empty($_REQUEST['product'])) {

        $auth = & $_SESSION['auth'];

        $product_groups = fn_get_shipping_rates_by_product($_REQUEST['product'], $auth);

        Tygh::$app['view']->assign('ship_product_groups', $product_groups);

        Tygh::$app['view']->assign('ship_block_id', $_REQUEST['ship_block_id']);

        Tygh::$app['view']->display('addons/ship_rates/blocks/product_ship_rates.tpl');

        exit;
    }

}
