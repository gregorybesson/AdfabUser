<?php
return array(
    'modules' => array(
        'Application',
        'DoctrineModule',
        'DoctrineORMModule',
        'ZfcBase',
        'ZfcUser',
        'ZfcAdmin',
        'AdfabUser',
        'AdfabReward',
        'AdfabCms',
        'AdfabFaq',
        'AdfabGame',
        'AdfabPartnership',
        'AdfabCore',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            '../../../config/autoload/{,*.}{global,local,testing}.php',
        ),
        'module_paths' => array(
            'module',
            'vendor',
        ),
    ),
);
