<?php

namespace AdfabUserTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class UserControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../TestConfig.php'
        );

        parent::setUp();
    }
    
    public function testAddressActionCanBeAccessed()
    {
    	$this->dispatch('/address');
    	$this->assertResponseStatusCode(200);
    
    	$this->assertModuleName('adfabuser_user');
    	$this->assertControllerName('application\controller\index');
    	$this->assertControllerClass('AddressController');
    	$this->assertActionName('address');
    	$this->assertMatchedRouteName('address');
    }
}
