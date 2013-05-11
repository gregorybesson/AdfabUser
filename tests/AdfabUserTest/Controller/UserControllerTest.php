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

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('application');
        $this->assertControllerName('application\controller\index');
        $this->assertControllerClass('IndexController');
        $this->assertActionName('index');
        $this->assertMatchedRouteName('home');
    }
}
