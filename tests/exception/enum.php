<?php

return array(
    'enum' => array(
        'SMSErrorCode' => array(
            'items' => array(
                array('name' => 'UNKNOWN_ERROR', 'value' => 0),
                array('name' => 'TOO_BUSY_ERROR', 'value' => 1),
                array('name' => 'DATABASE_ERROR', 'value' => 2),
                array('name' => 'EMPTY_MOBILE', 'value' => 3),
                array('name' => 'INVALID_MOBILE', 'value' => 4),
            )
        )
    )
);