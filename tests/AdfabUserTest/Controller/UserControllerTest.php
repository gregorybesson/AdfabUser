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

    /*public function testAddressActionCanBeAccessed()
    {
    	$this->dispatch('/address');
    	$this->assertResponseStatusCode(200);

    	$this->assertModuleName('adfabuser_user');
    	$this->assertControllerName('application\controller\index');
    	$this->assertControllerClass('AddressController');
    	$this->assertActionName('address');
    	$this->assertMatchedRouteName('address');
    }*/

    public function testLoginActionCanBeAccessed()
    {
    	$this->dispatch('/mon-compte/login');
    	$this->assertResponseStatusCode(302);

    	$this->assertModuleName('adfabuser');
    	$this->assertControllerName('adfabuser_user');
    	$this->assertControllerClass('UserController');
    	$this->assertActionName('login');
    	$this->assertMatchedRouteName('zfcuser/login');
    }

    public function testRegisterActionCanBeAccessed()
    {
    	$this->dispatch('/mon-compte/inscription');
    	$this->assertResponseStatusCode(200);

    	$this->assertModuleName('adfabuser');
    	$this->assertControllerName('adfabuser_user');
    	$this->assertControllerClass('UserController');
    	$this->assertActionName('register');
    	$this->assertMatchedRouteName('zfcuser/register');
    }

    public function testProfileNotLoggedIn()
    {
    	$this->dispatch('/mon-compte/mes-coordonnees');
    	$this->assertResponseStatusCode(302);

    	$this->assertModuleName('adfabuser');
    	$this->assertControllerName('adfabuser_user');
    	$this->assertControllerClass('UserController');
    	$this->assertActionName('profile');
    	$this->assertMatchedRouteName('zfcuser/profile');
    }
}
