<?php

function fn_my_only_update(&$pattern, $options)
{

    if ($options['only_update'] == 'Y') {
        $pattern['update_only'] = true;
    }

}
