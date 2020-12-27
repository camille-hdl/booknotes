<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Book;
use App\Entity\User;

class BookTest extends TestCase
{
    public function testConstruct()
    {
        $user = new User("test");
        $this->assertCount(0, $user->getBooks());
        $book = new Book($user);
        $this->assertCount(0, $book->getNotes());
        $this->assertCount(1, $user->getBooks());
        $this->assertEquals($user, $book->getUser());
    }
}
