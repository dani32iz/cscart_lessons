<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_get_shipping_rates_by_product($product, $auth) {

        static $sr_init_cache = false;

        $key = $product['product_id'] . '_' . $auth['user_id'] . '_' . DESCR_SL . '_' . CART_SECONDARY_CURRENCY;
        
        $cache_name = 'shipping_rates';

        if (!$sr_init_cache) {
            $condition = array('products', 'shippings', 'addons');
            Registry::registerCache($cache_name, $condition, Registry::cacheLevel('static'), true);
            $sr_init_cache = true;
        }

        $ship_cart = Registry::get($cache_name . '.' . $key);

        if (empty($ship_cart)) {

            $ship_cart = array(
                'products' => array(
                    0 => $product
                ),
                'recalculate' => true,
                'chosen_shipping' => array(),
                'calculate_shipping' => true
            );

            list($cart_products, $product_groups) = fn_calculate_cart_content($ship_cart, $auth, 'A', true, 'F', true);

            Registry::set($cache_name . '.' . $key, $ship_cart);
        }

        return $ship_cart['product_groups'];

}