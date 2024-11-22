<?php

namespace App\Tests\Entity;

use App\Entity\Order;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testOrderEntity()
    {
        $user = new User();
        $user->setEmail('john@doe.fr');

        $order = new Order();
        $order->setNumber('ORDER123');
        $order->setTotalPrice(199);
        $order->setUserId($user);

        $this->assertEquals(199, $order->getTotalPrice());
        $this->assertEquals('ORDER123', $order->getNumber());
        $this->assertEquals($user, $order->getUserId());
        $this->assertEquals('john@doe.fr', $order->getUserId()->getEmail());
    }
}
