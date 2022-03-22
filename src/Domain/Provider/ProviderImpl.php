<?php

declare(strict_types=1);

namespace App\Domain\Provider;

class ProviderImpl implements ProviderInterface
{

    public static function getPrice(): float
    {
        return 0.01;
    }

    public static function getPrefix(): string
    {
        return '+32';
    }

    public function send(array $phones, string $message): array
    {
        return ['count' => count($phones), 'price' => count($phones) * self::getPrice()];
    }
}