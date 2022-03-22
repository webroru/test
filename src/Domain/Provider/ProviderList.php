<?php

declare(strict_types=1);

namespace App\Domain\Provider;

use Assert\Assertion;

class ProviderList
{
    public function __construct(private array $providers)
    {
        Assertion::allIsInstanceOf($providers, ProviderInterface::class);
    }

    /**
     * @return ProviderInterface[]
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    public function get(string $name): ProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider instanceof $name) {
                return $provider;
            }
        }

        throw new \Exception('Provider not found');
    }

    /**
     * @param ProviderInterface[] $providers
     * @return ProviderInterface[]
     */
    public function sortByPrice(array $providers): array
    {
        usort($providers, fn(ProviderInterface $a, ProviderInterface $b) => $a::getPrice() <=> $b::getPrice());
        return $providers;
    }

    public function getByPrefix(string $prefix): array
    {
        $result = array_filter($this->providers, fn(ProviderInterface $provider) => $provider::getPrefix() === $prefix);
        if (!$result) {
            throw new \Exception("Provider doesn't support prefix $prefix");
        }

        return array_filter($this->providers, fn(ProviderInterface $provider) => $provider::getPrefix() === $prefix);
    }
}
