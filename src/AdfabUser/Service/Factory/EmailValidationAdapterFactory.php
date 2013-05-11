<?php

namespace AdfabUser\Service\Factory;

use AdfabUser\Authentication\Adapter\EmailValidation as EmailValidationAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EmailValidationAdapterFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {

        $adapter = new EmailValidationAdapter();

        return $adapter;
    }
}
