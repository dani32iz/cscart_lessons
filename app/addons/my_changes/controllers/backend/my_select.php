<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD']	== 'POST') {

    if ($mode == 'ops') {

        if (!empty($_REQUEST['order_id']) && !empty($_REQUEST['ops'])) {

            foreach($_REQUEST['ops'] as $item_id => $ops) {

                $data = array (
                    'ops' => $ops,
                );

                db_query('UPDATE ?:order_details SET ?u WHERE order_id = ?i AND item_id = ?i', $data, $_REQUEST['order_id'], $item_id);

            } 
        }

        exit;
    }

}

