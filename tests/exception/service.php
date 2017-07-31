<?php
return array(
    'service' => [
        'MessageService' => [
            'functions' => [
                'send' => [
                    'type' => 'TSMSSendText',
                    'name' => 'send',
                    'args' => array(
                        array('id' => 1, 'type' => 'TSMSSendParams', 'name' => 'params')
                    ),
                    'throws' => array(
                        array('id' => 1, 'type' => 'SMSUserException', 'name' => 'user_exception'),
                        array('id' => 2, 'type' => 'SMSSystemException', 'name' => 'system_exception'),
                        array('id' => 3, 'type' => 'SMSUnknownException', 'name' => 'unknown_exception'),
                    ),
                    'oneway' => false
                ],
                'ping' => [
                    'type' => 'bool',
                    'name' => 'ping',
                    'args' => array(),
                    'throws' => array(
                        array('id' => 1, 'type' => 'SMSUserException', 'name' => 'user_exception'),
                        array('id' => 2, 'type' => 'SMSSystemException', 'name' => 'system_exception'),
                        array('id' => 3, 'type' => 'SMSUnknownException', 'name' => 'unknown_exception'),
                    ),
                    'oneway' => false
                ],
            ]
        ]
    ]
);