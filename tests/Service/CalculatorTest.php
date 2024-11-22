<?php

namespace App\Tests\Service;

use App\Entity\Products;
use App\Service\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    private $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new Calculator();
    }

    private function createProduct(string $name, float $price): Products
    {
        $product = new Products();
        $product->setName($name)->setPrice($price);
        return $product;
    }

    private function getProducts(): array
    {
        $product1 = $this->createProduct('Apple', 100);
        $product2 = $this->createProduct('Banana', 200);

        return [
            ['product' => $product1, 'quantity' => 1],
            ['product' => $product2, 'quantity' => 2],
        ];
    }

    public function testGetTotalHT(): void
    {
        $products = $this->getProducts();
        
        $totalHT = $this->calculator->getTotalHT($products);

        $this->assertEquals(500, $totalHT);
    }

    public function testGetTotalTTC(): void
    {
        $products = $this->getProducts();
        
        $totalTTC = $this->calculator->getTotalTTC($products, 20);
        
        $this->assertEquals(600, $totalTTC);
    }
}
