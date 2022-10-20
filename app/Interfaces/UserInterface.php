<?php

namespace App\Interfaces;

interface UserInterface
{
    public function isCustomer(): bool;
    public function isAdmin(): bool;
}
