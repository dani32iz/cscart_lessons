<?php

use Tygh\Registry;

function fn_generate_uniq_email()
{
    // Получим уникальный id гостя
    $id = fn_get_id_for_email();

    // Настройки модуля
    $addon_info = Registry::get('addons.optional_email');

    // Собираем строку
    $email = $addon_info['email_prefix'] . $id . $addon_info['email_suffix'];

    return $email;
}

function fn_get_id_for_email()
{

    if (isset($_SESSION['settings']['cu_id']['value'])) {
        $id = $_SESSION['settings']['cu_id']['value'];
    } else {
        $id = 0;
    }

    return $id;

}