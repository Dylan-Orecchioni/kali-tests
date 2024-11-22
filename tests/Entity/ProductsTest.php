<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Products;

class ProductsTest extends TestCase {

    public function testProductsEntity()
    {
        $user = new Products();
        $user->setName('Apple');
        $user->setPrice(1);

        $this->assertEquals('Apple', $user->getName());
        $this->assertEquals(1, $user->getPrice());

    }
}