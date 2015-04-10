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

use Tygh\YImport\Import;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD']	== 'POST') {

    return true;
}

if ($mode == 'run') {

    if (!isset($_REQUEST['url_id']) && empty($_REQUEST['url_id'])) {
        die('empty url');
    }

    $url_data = fn_db_yml_get_url_by_id($_REQUEST['url_id']);

    if (!empty($url_data['url'])) {
        $import = new Import($url_data['url'], $url_data['price']);
        $import->run();

        fn_print_die($import->processed_data);

    } else {
        die('empty url');
    }

}