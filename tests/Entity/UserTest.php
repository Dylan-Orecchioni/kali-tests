<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Entity\Order;

class UserTest extends TestCase {

    public function testUserEntity()
    {
        $user = new User();

        $user->setLastname('Doe');
        $user->setFirstName('John');
        $user->setEmail('john@doe.fr');
        $user->setPassword('password');
        $user->setRoles(['ROLE_USER']);

        $this->assertEquals('Doe', $user->getLastname());
        $this->assertEquals('John', $user->getFirstName());
        $this->assertEquals('john@doe.fr', $user->getEmail());
        $this->assertEquals('password', $user->getPassword());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
        $this->assertEquals('john@doe.fr', $user->getUserIdentifier());
    }

    public function testAddOrder()
    {
        $user = new User();
        $user->setEmail('john@doe.fr');

        $order = new Order();
        $order->setNumber('ORDER123');
        $order->setTotalPrice(199);
        $order->setUserId($user);

        $user->addOrder($order);

        $this->assertCount(1, $user->getOrders());
        $this->assertSame($order, $user->getOrders()->first());
        $this->assertEquals($user, $order->getUserId());
    }

    public function testRemoveOrder()
    {
        $user = new User();
        $user->setEmail('john@doe.fr');

        $order = new Order();
        $order->setNumber('ORDER123');
        $order->setTotalPrice(199);
        $order->setUserId($user);

        $user->addOrder($order);
        $user->removeOrder($order);

        $this->assertCount(0, $user->getOrders());
        $this->assertNull($order->getUserId());
    }
}