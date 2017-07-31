<?php

return array(
    'exception' => array(
        'SMSUserException' => array(
            array('id' => 1, 'type' => 'SMSErrorCode', 'name' => 'error_code', 'option' => 'required'),
            array('id' => 2, 'type' => 'string', 'name' => 'error_name', 'option' => 'required'),
            array('id' => 3, 'type' => 'string', 'name' => 'message', 'option' => 'optional'),
        ),
        'SMSSystemException' => array(
            array('id' => 1, 'type' => 'SMSErrorCode', 'name' => 'error_code', 'option' => 'required'),
            array('id' => 2, 'type' => 'string', 'name' => 'error_name', 'option' => 'required'),
            array('id' => 3, 'type' => 'string', 'name' => 'message', 'option' => 'optional'),
        ),
        'SMSUnknownException' => array(
            array('id' => 1, 'type' => 'SMSErrorCode', 'name' => 'error_code', 'option' => 'required'),
            array('id' => 2, 'type' => 'string', 'name' => 'error_name', 'option' => 'required'),
            array('id' => 3, 'type' => 'string', 'name' => 'message', 'option' => 'required'),
        )
    )
);