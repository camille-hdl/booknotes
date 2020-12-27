<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Book;
use App\Entity\User;

class UserTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
        $this->myContainer = static::$kernel->getContainer();
        $this->em = $this->myContainer->get('doctrine')->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->myContainer = null;
        $this->em->close();
        $this->em = null;
    }
    public function testConstruct()
    {
        $user = new User("test");
        $this->assertNull($user->getId());
        $this->em->persist($user);
        dump($user->getId());
        $this->em->flush();
        dump($user->getId());
        $this->assertNotNull($user->getId());
    }
}
