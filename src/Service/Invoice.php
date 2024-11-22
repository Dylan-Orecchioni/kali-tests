<?php

namespace App\Service;

class Invoice
{
    private EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function process(string $email, float $amount): bool
    {
        $message = sprintf('Votre commande d’un montant de ' . $amount . '€ est confirmée', $amount);

        return $this->emailService->send($email, $message);
    }
}
