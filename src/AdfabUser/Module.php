<?php
/**
 * dependency Core
 * @author gbesson
 *
 */
namespace AdfabUser;

use Zend\Session\Container;
use Zend\Http\Request as HttpRequest;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use ZfcUser\Module as ZfcUser;
use Zend\Validator\AbstractValidator;

class Module
{
    public function init()
    {
    }

    public function onBootstrap($e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $em = $e->getApplication()->getEventManager();

        //Set the translator for default validation messages
        $translator = $sm->get('translator');
        AbstractValidator::setDefaultTranslator($translator,'adfabcore');

        $doctrine = $sm->get('zfcuser_doctrine_em');
        $evm = $doctrine->getEventManager();


        /* In some cases, this listener overrides those described further in application.config.php
        $listener = new  \Doctrine\ORM\Tools\ResolveTargetEntityListener();
        $listener->addResolveTargetEntity(
        		'AdfabUser\Entity\UserInterface',
        		'AdfabUser\Entity\User',
        		array()
        );
        $evm->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $listener);
        */

        //$options = $sm->get('zfcuser_module_options');
        //$reader = new AnnotationReader();

        /*
        // Add the default entity driver only if specified in configuration
        if ($options->getEnableDefaultEntities()) {
            $chain = $sm->get('doctrine.driver.orm_default');
            $chain->addDriver(new AnnotationDriver($reader, array(__DIR__.'/src/AdfabUser/Entity')), 'AdfabUser\Entity');
        }

        if (!$e->getRequest() instanceof HttpRequest) {
            return;
        }*/

        /*$session = new \Zend\Session\Container('zfcuser');
        $cookieLogin = $session->offsetGet("cookieLogin");

        $cookie = $e->getRequest()->getCookie();
        // do autologin only if not done before and cookie is present

        if (isset($cookie['remember_me']) && $cookieLogin == false) {
            $adapter = $e->getApplication()->getServiceManager()->get('ZfcUser\Authentication\Adapter\AdapterChain');
            $adapter->prepareForAuthentication($e->getRequest());
            $authService = $e->getApplication()->getServiceManager()->get('zfcuser_auth_service');

            $auth = $authService->authenticate($adapter);
        }*/

        // If cron is called, the $e->getRequest()->getQuery()->get('key'); produces an error so I protect it with
        // this test
        if ((get_class($e->getRequest()) == 'Zend\Console\Request')) {
            return;
        }
        $em->attach("dispatch", function($e) {
            $session = new Container('sponsorship');
            $key = $e->getRequest()->getQuery()->get('key');
            if ($key) {
                $session->offsetSet('key',  $key);
            }
        });

        // I can post cron tasks to be scheduled by the core cron service
        $em->getSharedManager()->attach('Zend\Mvc\Application','getCronjobs', array($this, 'addCronjob'));
    }

    /**
     * This method get the cron config for this module an add them to the listener
     * TODO : déporter la def des cron dans la config.
     *
     * @param  EventManager $e
     * @return array
     */
    public function addCronjob($e)
    {
        $cronjobs = $e->getParam('cronjobs');

        // This cron job is scheduled everyday @ 2AM en disable user in state 0 since 'period' (7 days here)
        $cronjobs['adfabuser_disable'] = array(
            'frequency' => '0 2 * * *',
            'callback'  => '\AdfabUser\Service\Cron::disableUser',
            'args'      => array('period' => 7),
        );

        return $cronjobs;
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'adfabUserLoginWidget' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\AdfabUserLoginWidget;
                    $viewHelper->setViewTemplate($locator->get('zfcuser_module_options')->getUserLoginWidgetViewTemplate());
                    $viewHelper->setLoginForm($locator->get('zfcuser_login_form'));

                    return $viewHelper;
                },
            ),
        );

    }

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                    'zfcuser_doctrine_em'  => 'doctrine.entitymanager.orm_default',
                    'adfabuser_message'    => 'adfabcore_message',
            ),

            'invokables' => array(
                    'AdfabUser\Authentication\Adapter\Cookie' => 'AdfabUser\Authentication\Adapter\Cookie',
                    'AdfabUser\Form\Login'                    => 'AdfabUser\Form\Login',
                    'adfabuser_user_service'                  => 'AdfabUser\Service\User',
                    'adfabuser_rememberme_service'            => 'AdfabUser\Service\RememberMe',
                    'adfabuser_password_service'              => 'AdfabUser\Service\Password',
                    'zfcuser_user_service'                    => 'AdfabUser\Service\User', // Extending ZfcUser service
                    'adfabuser_cron_service'                  => 'AdfabUser\Service\Cron',
                    'adfabuser_provider_service'              => 'AdfabUser\Service\Provider',
               ),

            'factories' => array(
                'adfabuser_authentication_emailvalidation'    => 'AdfabUser\Service\Factory\EmailValidationAdapterFactory',
                'adfabuser_authentication_hybridauth'         => 'AdfabUser\Service\Factory\HybridAuthAdapterFactory',
                'ZfcUser\Authentication\Adapter\AdapterChain' => 'AdfabUser\Service\Factory\AuthenticationAdapterChainFactory',
                'zfcuser_module_options' => function ($sm) {
                    $config = $sm->get('Configuration');

                    return new Options\ModuleOptions(isset($config['zfcuser']) ? $config['zfcuser'] : array());
                },
                'zfcuser_user_mapper' => function ($sm) {
                    return new \AdfabUser\Mapper\User(
                        $sm->get('zfcuser_doctrine_em'),
                        $sm->get('zfcuser_module_options')
                    );
                },
                'zfcuser_login_form' => function($sm) {
                    $translator = $sm->get('translator');
                    $options = $sm->get('zfcuser_module_options');
                    $form = new Form\Login(null, $options, $translator);
                    $form->setInputFilter(new \ZfcUser\Form\LoginFilter($options));

                    return $form;
                },

                'zfcuser_register_form' => function ($sm) {
                    $translator = $sm->get('translator');
                    $zfcUserOptions = $sm->get('zfcuser_module_options');
                    $form = new Form\Register(null, $zfcUserOptions, $translator, $sm );
                    //$form->setCaptchaElement($sm->get('zfcuser_captcha_element'));
                    $form->setInputFilter(new \ZfcUser\Form\RegisterFilter(
                        new \ZfcUser\Validator\NoRecordExists(array(
                            'mapper' => $sm->get('zfcuser_user_mapper'),
                            'key'    => 'email'
                        )),
                        new \ZfcUser\Validator\NoRecordExists(array(
                            'mapper' => $sm->get('zfcuser_user_mapper'),
                            'key'    => 'username'
                        )),
                        $zfcUserOptions
                    ));

                    return $form;
                },

                'SocialConfig' => function($sm) {
                $config = $sm->get('Config');
                $config = isset($config['adfabuser']['social']) ? $config['adfabuser']['social'] : false;

                $router = $sm->get('Router');
                // Bug when using doctrine from console https://github.com/SocalNick/ScnSocialAuth/issues/67
                if ($router instanceof \Zend\Mvc\Router\Http\TreeRouteStack) {
                    $request = $sm->get('Request');
                    if (!$router->getRequestUri() && method_exists($request, 'getUri')) {
                        $router->setRequestUri($request->getUri());
                    }
                    if (!$router->getBaseUrl() && method_exists($request, 'getBaseUrl')) {
                        $router->setBaseUrl($request->getBaseUrl());
                    }
                    $config['base_url'] = $router->assemble(
                        array(),
                        array(
                            'name' => 'zfcuser/backend',
                            'force_canonical' => true,
                        )
                    );
                }

                // If it's a console request (phpunit or doctrine console)...
                if (PHP_SAPI === 'cli') {
                    $_SERVER['HTTP_HOST'] = '127.0.0.1'.
                    $_SERVER['REQUEST_URI'] = 'zfcuser/backend';
                }

                // this following config doesn't work with bjyprofiler
                //https://github.com/SocalNick/ScnSocialAuth/issues/57
                //$urlHelper = $sm->get('viewhelpermanager')->get('url');
                //$config['base_url'] = $urlHelper('zfcuser/backend',array(), array('force_canonical' => true));
                return $config;
                },

                'HybridAuth' => function($sm) {
                    $config = $sm->get('SocialConfig');

                    return new \Hybrid_Auth($config);
                },

                'adfabuser_module_options' => function ($sm) {
                    $config = $sm->get('Configuration');

                    return new Options\ModuleOptions(isset($config['adfabuser']) ? $config['adfabuser'] : array());
                },

                'adfabuser_user_form' => function ($sm) {
                    $translator = $sm->get('translator');
                    $zfcUserOptions = $sm->get('zfcuser_module_options');
                    $form = new Form\Register(null, $zfcUserOptions, $translator);

                    return $form;
                },

                'adfabuseradmin_register_form' => function($sm) {
                    $translator = $sm->get('translator');
                    $zfcUserOptions = $sm->get('zfcuser_module_options');
                    $adfabUserOptions = $sm->get('adfabuser_module_options');
                    $form = new Form\Admin\User(null, $adfabUserOptions, $zfcUserOptions, $translator, $sm );
                    $filter = new \ZfcUser\Form\RegisterFilter(
                        new \ZfcUser\Validator\NoRecordExists(array(
                            'mapper' => $sm->get('zfcuser_user_mapper'),
                            'key'    => 'email'
                        )),
                        new \ZfcUser\Validator\NoRecordExists(array(
                            'mapper' => $sm->get('zfcuser_user_mapper'),
                            'key'    => 'username'
                        )),
                        $zfcUserOptions
                    );
                    if ($adfabUserOptions->getCreateUserAutoPassword()) {
                        $filter->remove('password')->remove('passwordVerify');
                    }
                    $form->setInputFilter($filter);

                    return $form;
                },

                'adfabuser_rememberme_mapper' => function ($sm) {
                    $options = $sm->get('zfcuser_module_options');
                    $rememberOptions = $sm->get('adfabuser_module_options');
                    $mapper = new Mapper\RememberMe;
                    $mapper->setDbAdapter($sm->get('zfcuser_zend_db_adapter'));
                    $entityClass = $rememberOptions->getRememberMeEntityClass();
                    $mapper->setEntityPrototype(new $entityClass);
                    $mapper->setHydrator(new Mapper\RememberMeHydrator());

                    return $mapper;
                },

                'adfabuser_emailverification_mapper' => function ($sm) {
                    return new \AdfabUser\Mapper\EmailVerification(
                        $sm->get('zfcuser_doctrine_em'),
                        $sm->get('zfcuser_module_options')
                    );
                },

                'adfabuser_role_mapper' => function ($sm) {
                    return new Mapper\Role(
                        $sm->get('zfcuser_doctrine_em'),
                        $sm->get('adfabuser_module_options')
                    );
                },

                'adfabuser_forgot_form' => function($sm) {
                    $options = $sm->get('adfabuser_module_options');
                    $translator = $sm->get('translator');
                    $form = new Form\Forgot(null, $options, $translator);
                    $form->setInputFilter(new Form\ForgotFilter($options));

                    return $form;
                },

                'adfabuser_reset_form' => function($sm) {
                    $options = $sm->get('adfabuser_module_options');
                    $translator = $sm->get('translator');
                    $form = new Form\Reset(null, $options, $translator);
                    $form->setInputFilter(new Form\ResetFilter($options));

                    return $form;
                },

                'adfabuser_change_info_form' => function($sm) {
                    $translator = $sm->get('translator');
                    $options = $sm->get('adfabuser_module_options');
                    $form = new Form\ChangeInfo(null, $options, $translator);

                    return $form;
                },

                'adfabuser_blockaccount_form' => function($sm) {
                    $translator = $sm->get('translator');
                    $options = $sm->get('zfcuser_module_options');
                    $form = new Form\BlockAccount(null, $sm->get('zfcuser_module_options'), $translator);
                    $form->setInputFilter(new Form\BlockAccountFilter($options));

                    return $form;
                },

                'adfabuser_newsletter_form' => function($sm) {
                    $translator = $sm->get('translator');
                    $options = $sm->get('zfcuser_module_options');
                    $form = new Form\Newsletter(null, $sm->get('zfcuser_module_options'), $translator);
                    $form->setInputFilter(new Form\NewsletterFilter($options));

                    return $form;
                },

                'adfabuser_address_form' => function($sm) {
                    $translator = $sm->get('translator');
                    $options = $sm->get('adfabuser_module_options');
                    $form = new Form\Address(null, $options, $translator);

                    return $form;
                },

                'adfabuser_password_mapper' => function ($sm) {
                    $options = $sm->get('adfabuser_module_options');
                    $mapper = new Mapper\Password;
                    $mapper->setDbAdapter($sm->get('zfcuser_zend_db_adapter'));
                    $entityClass = $options->getPasswordEntityClass();
                    $mapper->setEntityPrototype(new $entityClass);
                    $mapper->setHydrator(new Mapper\PasswordHydrator());

                    return $mapper;
                },

                'adfabuser_userprovider_mapper' => function ($sm) {
                    return new Mapper\UserProvider(
                        $sm->get('zfcuser_doctrine_em'),
                        $sm->get('adfabuser_module_options')
                    );
                },
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
}
