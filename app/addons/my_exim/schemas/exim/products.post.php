<?php


$schema['options']['only_update'] = array(
    'title' => 'my_exim.only_update',
    'type' => 'checkbox',
    'import_only' => true
);

$schema['import_process_data']['only_update'] = array(
    'function' => 'fn_my_only_update',
    'args' => array('$pattern', '$options'),
    'import_only' => true,
);

return $schema;
