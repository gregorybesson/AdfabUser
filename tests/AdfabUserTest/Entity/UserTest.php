<?php

namespace AdfabUserTest\Entity;

use AdfabUserTest\Bootstrap;
use AdfabUser\Entity\User;

class userTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Service Manager
     * @var Zend\ServiceManager\ServiceManager
     */
    protected $sm;

    /**
     * Doctrine Entity Manager
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setUp()
    {
        $this->sm = Bootstrap::getServiceManager();
        $this->em = $this->sm->get('doctrine.entitymanager.orm_default');

        parent::setUp();
    }

    public function testCanInsertNewRecord()
    {
        $data = array(
            'email' => 'correct@test.com',
            'firstname' => 'Jo',
            'lastname'  => 'Lindien'
        );

        $user = new User();
        $user->populate($data);
        $rand = \Zend\Math\Rand::getString(8);
        $bcrypt = new \Zend\Crypt\Password\Bcrypt;
        $bcrypt->setCost(6);
        $pass = $bcrypt->create($rand);
        $user->setPassword($pass);
        // save data
        $this->em->persist($user);
        $this->em->flush();

        $this->assertEquals($data['email'], $user->getEmail());

        return $user->getId();
    }

    /**
     * @depends testCanInsertNewRecord
     */
    public function testCanUpdateInsertedRecord($id)
    {
        $data = array(
            'id' => $id,
            'email' => 'correct@test.com',
            'firstname' => 'Gerry'
        );
        $user = $this->em->getRepository('AdfabUser\Entity\User')->find($id);
        $this->assertInstanceOf('AdfabUser\Entity\User', $user);
        $this->assertEquals($data['email'], $user->getEmail());

        $user->populate($data);
        $this->em->flush();

        $this->assertEquals($data['email'], $user->getEmail());
    }

    /**
     * @depends testCanInsertNewRecord
     */
    public function testCanRemoveInsertedRecord($id)
    {
        $user = $this->em->getRepository('AdfabUser\Entity\User')->find($id);
        $this->assertInstanceOf('AdfabUser\Entity\User', $user);

        $this->em->remove($user);
        $this->em->flush();

        $user = $this->em->getRepository('AdfabUser\Entity\User')->find($id);
        $this->assertEquals(false, $user);
    }

    public function tearDown()
    {
        $dbh = $this->em->getConnection();
        //$result = $dbh->exec("UPDATE sqlite_sequence SET seq = 10 WHERE name='album';");

        unset($this->sm);
        unset($this->em);
        parent::tearDown();
    }
}
