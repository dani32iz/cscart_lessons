<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }


function fn_my_changes_update_product_post($product_data, $product_id, $lang_code, $create)
{

    if (!empty($create)) {

        db_query("UPDATE ?:product_descriptions SET full_description = '' WHERE product_id = ?i AND lang_code != ?s", $product_id, $lang_code);

    }

}

function fn_my_changes_get_products_before_select($params, $join, &$condition, $u_condition, $inventory_condition, $sortings, $total, $items_per_page, $lang_code, $having)
{

    if (AREA == 'C') {

        $condition .= db_quote(" AND descr1.full_description IS NOT NULL AND descr1.full_description <> ''");

    }

}
