<?php
return array(

    'doctrine' => array(
        'driver' => array(
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => __DIR__ . '/../src/AdfabUser/Entity'
            ),

            'orm_default' => array(
                'drivers' => array(
                    'AdfabUser\Entity'  => 'zfcuser_entity'
                )
            )
        )
    ),
		
	'bjyauthorize' => array(
		'default_role' => 'guest',
		'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationDoctrineEntity',
		'role_providers' => array(
			'BjyAuthorize\Provider\Role\Config' => array(
				'guest' => array(),
				'user'  => array('children' => array(
					'admin' => array(),
				))
			),
		),
	),

	'data-fixture' => array(
		'AdfabUser_fixture' => __DIR__ . '/../src/AdfabUser/DataFixtures/ORM',
	),

    'core_layout' => array(
        'AdfabUser' => array(
            'default_layout' => 'adfab-user/layout/2columns-left',
            'controllers' => array(
            	'adfabuseradmin' => array(
            		'default_layout' => 'layout/admin',
            	),
            	'adfabuseradmin_login' => array(
           			'default_layout' => 'layout/adminlogin',
           		),
                'adfabuser_user'   => array(
                    'default_layout' => 'adfab-user/layout/2columns-left',
                    'children_views' => array(
                        'col_left'  => 'adfab-user/layout/col-user.phtml',
                    ),
                    'actions' => array(
                        'index' => array(
                            'default_layout' => 'adfab-user/layout/1column',
                        ),
                        'register' => array(
                            'default_layout' => 'adfab-user/layout/1column',
                        ),
                        'profile' => array(
                            'default_layout' => 'adfab-user/layout/2columns-left',
                            'children_views' => array(
                                'col_left'  => 'adfab-user/layout/col-user.phtml',
                            ),
                        ),
                        'registermail' => array(
                            'default_layout' => 'adfab-user/layout/1column',
                        ),
                    ),
                ),
                'adfabuser_forgot' => array(
                    'default_layout' => 'adfab-user/layout/1column',
                    'actions' => array(
                        'forgot' => array(
                            'default_layout' => 'adfab-user/layout/1column',
                        ),
                        'resetpassword' => array(
                            'default_layout' => 'adfab-user/layout/1column',
                        ),
                        'forgotpassword' => array(
                            'default_layout' => 'adfab-user/layout/1column',
                        ),
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view/admin',
            __DIR__ . '/../view/frontend',
        ),
    ),

    'translator' => array(
        'locale' => 'fr_FR',
        'translation_file_patterns' => array(
            array(
                'type'         => 'phpArray',
                'base_dir'     => __DIR__ . '/../language',
                'pattern'      => '%s.php',
                'text_domain'  => 'adfabuser'
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
        	'adfabuseradmin_login' => 'AdfabUser\Controller\Admin\LoginController',
            'adfabuseradmin'       => 'AdfabUser\Controller\Admin\AdminController',
            'adfabuser_user'       => 'AdfabUser\Controller\UserController',
            'adfabuser_forgot'     => 'AdfabUser\Controller\ForgotController',
        ),
    ),

    'router' => array(
        'routes' => array(
        	'frontend' => array(
       			'child_routes' => array(
		            'zfcuser' => array(
		                'type' => 'Literal',
		                'priority' => 1000,
		                'options' => array(
		                    'route' => 'mon-compte',
		                    'defaults' => array(
		                        'controller' => 'zfcuser',
		                        'action'     => 'index',
		                    ),
		                ),
		                'may_terminate' => true,
		                'child_routes' => array(
		                    'forgotpassword' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/mot-passe-oublie',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_forgot',
		                                'action'     => 'forgot',
		                            ),
		                        ),
		                    ),
		                    'ajaxlogin' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/ajaxlogin',
		                            'defaults' => array(
		                                    'controller' => 'adfabuser_user',
		                                    'action'     => 'ajaxlogin',
		                            ),
		                        ),
		                    ),
		                    'login' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/login',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action'     => 'login',
		                            ),
		                        ),
		                        'may_terminate' => true,
		                        'child_routes' => array(
		                            'provider' => array(
		                                'type' => 'Segment',
		                                'options' => array(
		                                    'route' => '/:provider',
		                                    'constraints' => array(
		                                        'provider' => '[a-zA-Z][a-zA-Z0-9_-]+',
		                                    ),
		                                    'defaults' => array(
		                                        'controller' => 'adfabuser_user',
		                                        'action' => 'providerLogin',
		                                    ),
		                                ),
		                            ),
		                        ),
		                    ),
		                    'logout' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/logout',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action'     => 'logout',
		                            ),
		                        ),
		                    ),
		                    'ajaxauthenticate' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/ajaxauthenticate',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action'     => 'ajaxauthenticate',
		                            ),
		                        ),
		                    ),
		                    'authenticate' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                                'route' => '/authenticate',
		                                'defaults' => array(
		                                        'controller' => 'zfcuser',
		                                        'action'     => 'authenticate',
		                                ),
		                        ),
		                    ),
		                    'resetpassword' => array(
		                        'type' => 'Segment',
		                        'options' => array(
		                            'route' => '/reset-password/:userId/:token',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_forgot',
		                                'action'     => 'reset',
		                            ),
		                            'constraints' => array(
		                                'userId'  => '[0-9]+',
		                                'token' => '[A-F0-9]+',
		                            ),
		                        ),
		                    ),
		                    'register' => array(
		                        'type' => 'Segment',
		                        'options' => array(
		                            'route' => '/inscription[/:socialnetwork]',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action'     => 'register',
		                            ),
		                        ),
		                    ),
		                    'registermail' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/registermail',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action'     => 'registermail',
		                            ),
		                        ),
		                    ),
		                    'verification' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/verification',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action'     => 'check-token',
		                            ),
		                        ),
		                    ),
		                    'backend' => array(
		                        'type' => 'Segment',
		                        'options' => array(
		                            'route' => '/backend',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action' => 'HybridAuthBackend'
		                            )
		                        ),
		                    ),
		
		                    'profile' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/mes-coordonnees',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action'     => 'profile',
		                            ),
		                        ),
		                    ),
		                    'profile_prizes' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/prizes',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action'     => 'prizeCategoryUser',
		                            ),
		                        ),
		                    ),
		                    'newsletter' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/newsletter',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action'     => 'newsletter',
		                            ),
		                        ),
		                    ),
		                    'ajax_newsletter' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/ajax-newsletter',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action'     => 'ajaxNewsletter',
		                            ),
		                        ),
		                    ),
		                    'changepassword' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/change-password',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action'     => 'changepassword',
		                            ),
		                        ),
		                    ),
		                    'blockaccount' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/block-account',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action'     => 'blockAccount',
		                            ),
		                        ),
		                    ),
		                    'changeemail' => array(
		                        'type' => 'Literal',
		                        'options' => array(
		                            'route' => '/change-email',
		                            'defaults' => array(
		                                'controller' => 'adfabuser_user',
		                                'action' => 'changeemail',
		                            ),
		                        ),
		                    ),
		                ),
		            ),
       			),
        	),
            'admin' => array(
            	'options' => array(
            		'defaults' => array(
           				'controller' => 'adfabuseradmin_login',
           				'action'     => 'login',
            		),
            	),
                'child_routes' => array(
                    'adfabuser' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/user',
                            'defaults' => array(
                                'controller' => 'adfabuseradmin',
                                'action'     => 'index',
                            ),
                        ),
                        'child_routes' =>array(
                            'list' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/list/:roleId[/:filter][/:p]',
                                    'defaults' => array(
                                        'controller' => 'adfabuseradmin',
                                        'action'     => 'list',
                                        'roleId' 	 => 'user',
                                        'filter' 	 => 'DESC'
                                    ),
                                    'constraints' => array(
                                        'filter' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ),
                                ),
                                /*'may_terminate' => true,
                                'child_routes' => array(
                                    'pagination' => array(
                                        'type'    => 'Segment',
                                        'options' => array(
                                            'route'    => '[/:p]',
                                            'defaults' => array(
                                                'controller' => 'adfabuseradmin',
                                                'action'     => 'list',
                                            ),
                                        ),
                                    ),
                                ),*/
                            ),
                            'create' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/create/:userId',
                                    'defaults' => array(
                                        'controller' => 'adfabuseradmin',
                                        'action'     => 'create',
                                        'userId'     => 0
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:userId',
                                    'defaults' => array(
                                        'controller' => 'adfabuseradmin',
                                        'action'     => 'edit',
                                        'userId'     => 0
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:userId',
                                    'defaults' => array(
                                        'controller' => 'adfabuseradmin',
                                        'action'     => 'remove',
                                        'userId'     => 0
                                    ),
                                ),
                            ),
                            'activate' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/activate/:userId',
                                    'defaults' => array(
                                        'controller' => 'adfabuseradmin',
                                        'action'     => 'activate',
                                        'userId'     => 0
                                    ),
                                ),
                            ),
                            'reset' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/reset/:userId',
                                    'defaults' => array(
                                        'controller' => 'adfabuseradmin',
                                        'action'     => 'reset',
                                        'userId'     => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'navigation' => array(
        'default' => array(
            'register' => array(
                'label' => 'Inscrivez-vous ou accédez à votre compte',
                'route' => 'inscription[/:socialnetwork]',
                'controller' => 'adfabuser_user',
                'action'     => 'register',
            ),
            'profile' => array(
                'label' => 'Modifier mes informations',
                'route' => 'profile',
                'controller' => 'adfabuser_user',
                'action'     => 'profile',
            ),
            'registermail' => array(
                'label' => 'Inscrivez-vous ou accédez à votre compte',
                'route' => 'registermail',
                'controller' => 'adfabuser_user',
                'action'     => 'registermail',
            ),

            'newsletter' => array(
                'label' => 'Newsletter',
                'route' => 'zfcuser/newsletter',
                'controller' => 'adfabuser_user',
                'action'     => 'newsletter',
            ),
            'resetpassword' => array(
                'label' => 'Mot de passe oublié ?',
                'route' => 'reset-password/:userId/:token',
                'controller' => 'adfabuser_forgot',
                'action'     => 'reset',
            ),
            'forgotpassword' => array(
                'label' => 'Mot de passe oublié ?',
                'route' => 'mot-passe-oublie',
                'controller' => 'adfabuser_forgot',
                'action'     => 'forgot',
            ),
        ),
        'admin' => array(
            'adfabuser' => array(
                'label' => 'Utilisateurs',
                'route' => 'admin/adfabuser/list',
                'resource' => 'user',
                'privilege' => 'list',
                'pages' => array(
                    'list' => array(
                        'label' => 'Liste des utilisateurs',
                        'route' => 'admin/adfabuser/list',
                        'resource' => 'user',
                        'privilege' => 'list',
                    ),
                    'create' => array(
                        'label' => 'Créer un utilisateur',
                        'route' => 'admin/adfabuser/create',
                        'resource' => 'user',
                        'privilege' => 'add',
                    ),
                    'edit' => array(
                        'label' => 'Editer un utilisateur',
                        'route' => 'admin/adfabuser/edit',
                        'privilege' => 'edit',
                    ),
                ),
            ),
        ),
    ),

    'adfabuser' => array(
        // add default registration role to BjyAuthorize
        'default_register_role' => 'user',
        'user_list_elements' => array(
            'Id' => 'id',
            'Email address' => 'email',
            'Username' => 'username',
            'Firstname' => 'firstname',
            'Lastname' => 'lastname',
            'Telephone' => 'telephone',
            'Mobile' => 'mobile',
        ),
        'create_form_elements' => array(
            // username & password are already added by default form
            'Firstname' => 'firstname',
            'Lastname' => 'lastname',
            'Telephone' => 'Telephone',
            'Mobile' => 'mobile',
        ),
        'edit_form_elements' => array(
            'Username' => 'username',
            'Email' => 'email',
            'Firstname' => 'firstname',
            'Lastname' => 'lastname',
            'Telephone' => 'Telephone',
            'Mobile' => 'mobile',
            //'Created at' => 'createdAt',
            //'Updated at' => 'updatedAt'
        ),
        'new_email_subject_line' => 'your new password',
        //'create_user_auto_password' => true
    )
);
