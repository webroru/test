<?php

declare(strict_types=1);

namespace App\Domain\Provider;

interface ProviderInterface
{
    const COUNT = 'count';
    const PRICE = 'price';
    public static function getPrice(): float;
    public static function getPrefix(): string;
    public function send(array $phones, string $message): array;
}