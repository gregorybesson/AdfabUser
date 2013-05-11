<?php

namespace AdfabUser\Service\Factory;

use AdfabUser\Authentication\Adapter\HybridAuth as HybridAuthAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   ScnSocialAuth
 * @package    ScnSocialAuth_Service
 */
class HybridAuthAdapterFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $hybridAuth = $services->get('HybridAuth');

        $moduleOptions = $services->get('adfabuser_module_options');
        $zfcUserOptions = $services->get('zfcuser_module_options');

        $mapper = $services->get('adfabuser_userprovider_mapper');
        $zfcUserMapper = $services->get('zfcuser_user_mapper');

        $adapter = new HybridAuthAdapter();
        $adapter->setHybridAuth($hybridAuth);
        $adapter->setOptions($moduleOptions);
        $adapter->setZfcUserOptions($zfcUserOptions);
        $adapter->setMapper($mapper);
        $adapter->setZfcUserMapper($zfcUserMapper);

        return $adapter;
    }
}
