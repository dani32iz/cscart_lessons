<?php

// Если POST запрос
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Если есть массив с данными о покупателе и в массиве пустой email.
    if (isset($_REQUEST['user_data']['email']) && empty($_REQUEST['user_data']['email'])) {

        // Добавим email 
        $_REQUEST['user_data']['email'] = fn_generate_uniq_email();

    }

}

