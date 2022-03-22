<?php

declare(strict_types=1);

namespace App\Domain\Message;

class MessageDTO
{
    public function __construct(
        private string $message,
        private array $phones = [],
    ) {}

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getPhones(): array
    {
        return $this->phones;
    }

    public function addPhone(string $phone): self
    {
        $this->phones[] = $phone;
        return $this;
    }
}
