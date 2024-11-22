<?php

namespace App\Service;

class Calculator
{
    public function getTotalHT(array $products): int
    {
        $totalHT = 0;
        foreach ($products as $product) {
            $totalHT += $product['product']->getPrice() * $product['quantity'];
        }
        return $totalHT;
    }

    public function getTotalTTC(array $products, int $taxRate): int
    {
        $totalTTC = 0;
        foreach ($products as $product) {
            $totalTTC += $product['product']->getPrice() * $product['quantity'] * (1 + $taxRate / 100);
        }
        return $totalTTC;
    }
}