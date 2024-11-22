<?php

namespace App\Service;

class EmailService 
{
    public function send(string $email, string $message) 
    {
        return (bool)random_int(0, 1);
    }
}