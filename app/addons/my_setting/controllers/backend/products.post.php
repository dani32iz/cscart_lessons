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

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    return array(CONTROLLER_STATUS_OK);
}

if ($mode == 'manage') {

    $selected_fields = Registry::get('view')->getTemplateVars('selected_fields');

    $selected_fields[] = array('name' => '[data][yml_brand]', 'text' => __('yml_brand'));
    $selected_fields[] = array('name' => '[data][yml_origin_country]', 'text' => __('yml_country'));
    $selected_fields[] = array('name' => '[data][yml_store]', 'text' => __('yml_store'));
    $selected_fields[] = array('name' => '[data][yml_pickup]', 'text' => __('yml_pickup'));
    $selected_fields[] = array('name' => '[data][yml_delivery]', 'text' => __('yml_delivery'));
    if (Registry::get('addons.yandex_market.local_delivery_cost') == 'Y') {
        $selected_fields[] = array('name' => '[data][yml_cost]', 'text' => __('yml_cost'));
    }
    $selected_fields[] = array('name' => '[data][yml_export_yes]', 'text' => __('yml_export_yes'));
    $selected_fields[] = array('name' => '[data][yml_bid]', 'text' => __('yml_bid'));
    $selected_fields[] = array('name' => '[data][yml_cbid]', 'text' => __('yml_cbid'));
    $selected_fields[] = array('name' => '[data][yml_model]', 'text' => __('yml_model'));
    $selected_fields[] = array('name' => '[data][yml_market_category]', 'text' => __('yml_market_category'));
    $selected_fields[] = array('name' => '[data][yml_sales_notes]', 'text' => __('yml_sales_notes'));
    $selected_fields[] = array('name' => '[data][yml_type_prefix]', 'text' => __('yml_type_prefix'));
    $selected_fields[] = array('name' => '[data][yml_manufacturer_warranty]', 'text' => __('yml_manufacturer_warranty'));
    $selected_fields[] = array('name' => '[data][yml_seller_warranty]', 'text' => __('yml_seller_warranty'));

    Registry::get('view')->assign('selected_fields', $selected_fields);

} elseif ($mode == 'm_update') {

    $selected_fields = $_SESSION['selected_fields'];

    $field_groups = Registry::get('view')->getTemplateVars('field_groups');
    $filled_groups = Registry::get('view')->getTemplateVars('filled_groups');
    $field_names = Registry::get('view')->getTemplateVars('field_names');

    if (!empty($selected_fields['data']['yml_brand'])) {
        $field_groups['A']['yml_brand'] = 'products_data';
        $filled_groups['A']['yml_brand'] = __('yml_brand');
        unset($field_names['yml_brand']);
    }

    if (!empty($selected_fields['data']['yml_sales_notes'])) {
        $field_groups['A']['yml_sales_notes'] = 'products_data';
        $filled_groups['A']['yml_sales_notes'] = __('yml_sales_notes');
        unset($field_names['yml_sales_notes']);
    }

    if (!empty($selected_fields['data']['yml_market_category'])) {
        $field_groups['A']['yml_market_category'] = 'products_data';
        $filled_groups['A']['yml_market_category'] = __('yml_market_category');
        unset($field_names['yml_market_category']);
    }

    if (!empty($selected_fields['data']['yml_type_prefix'])) {
        $field_groups['A']['yml_type_prefix'] = 'products_data';
        $filled_groups['A']['yml_type_prefix'] = __('yml_type_prefix');
        unset($field_names['yml_type_prefix']);
    }

    if (!empty($selected_fields['data']['yml_origin_country'])) {
        $field_groups['A']['yml_origin_country'] = 'products_data';
        $filled_groups['A']['yml_origin_country'] = __('yml_country');
        unset($field_names['yml_origin_country']);
    }

    if (!empty($selected_fields['data']['yml_store'])) {
        $field_groups['S']['yml_store']['name'] = 'products_data';
        $field_groups['S']['yml_store']['variants'] = array(
            'Y' => 'yes',
            'N' => 'no',
        );
        $filled_groups['S']['yml_store'] = __('yml_store');
        unset($field_names['yml_store']);
    }

    if (!empty($selected_fields['data']['yml_pickup'])) {
        $field_groups['S']['yml_pickup']['name'] = 'products_data';
        $field_groups['S']['yml_pickup']['variants'] = array(
            'Y' => 'yes',
            'N' => 'no',
        );
        $filled_groups['S']['yml_pickup'] = __('yml_pickup');
        unset($field_names['yml_pickup']);
    }

    if (!empty($selected_fields['data']['yml_delivery'])) {
        $field_groups['S']['yml_delivery']['name'] = 'products_data';
        $field_groups['S']['yml_delivery']['variants'] = array(
            'Y' => 'yes',
            'N' => 'no',
        );
        $filled_groups['S']['yml_delivery'] = __('yml_delivery');
        unset($field_names['yml_delivery']);
    }

    if (!empty($selected_fields['data']['yml_cost'])) {
        $field_groups['A']['yml_cost'] = 'products_data';
        $filled_groups['A']['yml_cost'] = __('yml_cost');
        unset($field_names['yml_cost']);
    }

    if (!empty($selected_fields['data']['yml_export_yes'])) {
        $field_groups['S']['yml_export_yes']['name'] = 'products_data';
        $field_groups['S']['yml_export_yes']['variants'] = array(
            'Y' => 'yes',
            'N' => 'no',
        );
        $filled_groups['S']['yml_export_yes'] = __('yml_export_yes');
        unset($field_names['yml_export_yes']);
    }

    if (!empty($selected_fields['data']['yml_bid'])) {
        $field_groups['A']['yml_bid'] = 'products_data';
        $filled_groups['A']['yml_bid'] = __('yml_bid');
        unset($field_names['yml_bid']);
    }

    if (!empty($selected_fields['data']['yml_cbid'])) {
        $field_groups['A']['yml_cbid'] = 'products_data';
        $filled_groups['A']['yml_cbid'] = __('yml_cbid');
        unset($field_names['yml_cbid']);
    }

    if (!empty($selected_fields['data']['yml_model'])) {
        $field_groups['A']['yml_model'] = 'products_data';
        $filled_groups['A']['yml_model'] = __('yml_model');
        unset($field_names['yml_model']);
    }
    
    if (!empty($selected_fields['data']['yml_manufacturer_warranty'])) {
        $field_groups['A']['yml_manufacturer_warranty'] = 'products_data';
        $filled_groups['A']['yml_manufacturer_warranty'] = __('yml_manufacturer_warranty');
        unset($field_names['yml_manufacturer_warranty']);
    }
    
    if (!empty($selected_fields['data']['yml_seller_warranty'])) {
        $field_groups['A']['yml_seller_warranty'] = 'products_data';
        $filled_groups['A']['yml_seller_warranty'] = __('yml_seller_warranty');
        unset($field_names['yml_seller_warranty']);
    }

    Registry::get('view')->assign('field_groups', $field_groups);
    Registry::get('view')->assign('filled_groups', $filled_groups);
    Registry::get('view')->assign('field_names', $field_names);

}
