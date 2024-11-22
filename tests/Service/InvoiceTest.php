<?php

namespace App\Tests\Service;

use App\Service\EmailService;
use App\Service\Invoice;
use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    
    public function testProcess(): void
    {
    
        /** @var EmailService&\PHPUnit\Framework\MockObject\MockObject $emailServiceMock */
        $emailServiceMock = $this->createMock(EmailService::class);

        $emailServiceMock
            ->expects($this->once())
            ->method('send')
            ->with(
                $this->equalTo('customer@example.com'),
                $this->stringContains('Votre commande d’un montant de')
            )
            ->willReturn(true);

        $invoice = new Invoice($emailServiceMock);
        $invoice->process('customer@example.com', 100);
    }
}
