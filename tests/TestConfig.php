<?php
return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'ZfcBase',
        'ZfcUser',
        'ZfcAdmin',
    	'AdfabCore',
        'AdfabUser',
        'AdfabReward',
        'AdfabCms',
        'AdfabFaq',
        'AdfabGame',
        'AdfabPartnership',
    	'Application'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            '../../../../config/autoload/{,*.}{global,local,testing}.php',
        ),
        'module_paths' => array(
            'module',
            'vendor',
        ),
    ),
);
