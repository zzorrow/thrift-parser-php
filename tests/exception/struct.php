<?php

return array(
    'struct' => array(
        'TSMSSendParams' => array(
            array('id' => 1, 'type' => 'Mobile', 'name' => 'mobile', 'option' => 'required'),
            array('id' => 2, 'type' => 'string', 'name' => 'template', 'option' => 'required'),
            array('id' => 3, 'type' => 'string', 'name' => 'type', 'option' => 'optional'),
            array('id' => 4, 'type' => 'string', 'name' => 'channel', 'option' => 'optional'),
            array('id' => 5, 'type' => array(
                'name' => 'map', 'keyType' => 'string', 'valueType' => 'string'
            ), 'name' => 'params', 'option' => 'optional')
        ),
        'TSMSSendText' => array(
            array('id' => 1, 'type' => 'Mobile', 'name' => 'mobile', 'option' => 'required'),
            array('id' => 2, 'type' => 'string', 'name' => 'template', 'option' => 'required'),
            array('id' => 3, 'type' => 'i32', 'name' => 'code', 'option' => 'required'),
            array('id' => 4, 'type' => 'i32', 'name' => 'success', 'option' => 'optional'),
            array('id' => 5, 'type' => 'string', 'name' => 'channel', 'option' => 'optional'),
            array('id' => 6, 'type' => 'i32', 'name' => 'error_code', 'option' => 'optional'),
        )
    )
);