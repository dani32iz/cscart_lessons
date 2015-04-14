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

function fn_db_yml_import_update_product_post(&$product_data, &$product_id)
{

    if (isset($product_data['yml_offer_id'])) {
        fn_db_yml_import_update_offer_id($product_id, $product_data['yml_offer_id']);        
    }

    return true;
}


function fn_db_yml_import_get_product_data(&$product_id, &$field_list, &$join, &$auth)
{
    $field_list .= ', ?:yml_import_objects.offer_id as yml_offer_id';
    $join .= ' LEFT JOIN ?:yml_import_objects ON ?:yml_import_objects.product_id = ?:products.product_id';
}


function fn_db_yml_import_get_offer_id($product_id)
{
    
    $offer_id = db_get_field("SELECT offer_id FROM ?:yml_import_objects WHERE product_id = ?i", $product_id);
    
    return $offer_id;

}

function fn_db_yml_import_update_offer_id($product_id, $offer_id)
{

    if (!empty($offer_id)) {
        $_data = array (
            'product_id' => $product_id,
            'offer_id' => $offer_id,
        );

        db_query("REPLACE INTO ?:yml_import_objects ?e", $_data);
    } 

}

function fn_db_yml_import_update_url($url_data)
{

    if (!empty($url_data['url'])) {

        $url_id = db_query("REPLACE INTO ?:yml_import_urls ?e", $url_data);

        return $url_id;
    } 

}

function fn_db_yml_import_get_urls()
{

    $_urls = db_get_array("SELECT * FROM ?:yml_import_urls");

    if (!empty($_urls)) {
        foreach ($_urls as $value) {
            $urls[$value['url_id']] = $value;
        }        
    } else {
        $urls = false;
    }

    return $urls;

}


function fn_db_yml_get_url_by_id($url_id)
{

    $url_data = db_get_row("SELECT * FROM ?:yml_import_urls WHERE url_id = ?i", $url_id);

    return $url_data;

}


function fn_db_yml_import_delete_urls($url_ids)
{

    if (!empty($url_ids)) {
        foreach ($url_ids as $id) {
            db_query("DELETE FROM ?:yml_import_urls WHERE url_id = ?i", $id);
        }
    }

}

/**
 * Delete from yml_import_objects
 *
 */

function fn_db_yml_import_delete_product_post(&$product_id)
{
    db_query("DELETE FROM ?:yml_import_objects WHERE product_id = ?i", $product_id);

    return true;
}

