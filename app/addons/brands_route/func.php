<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

if (!defined('BOOTSTRAP')) { die('Access denied'); }


function fn_settings_variants_addons_brands_route_filter_id()
{
    $filters = db_get_hash_single_array(
        "SELECT a.filter_id, b.filter"
        . " FROM ?:product_filters as a"
        . " LEFT JOIN ?:product_filter_descriptions as b ON a.filter_id = b.filter_id"
        . " LEFT JOIN ?:product_features as f ON a.feature_id = f.feature_id"
        . " WHERE f.feature_type = ?s AND b.lang_code = ?s",
        array('filter_id', 'filter'), 'E', DESCR_SL
    );

    return $filters;
}
