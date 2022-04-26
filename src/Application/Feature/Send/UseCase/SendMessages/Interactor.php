<?php

namespace App\Application\Feature\Send\UseCase\SendMessages;

use App\Domain\Message\MessageDTO;
use App\Domain\Message\MessageSplitter;
use App\Domain\Provider\ProviderInterface;
use App\Domain\Provider\ProviderList;

class Interactor
{
    private array $messageDTOList = [];

    public function __construct(
        private ProviderList $providerList,
        private MessageSplitter $messageSplitter,
    )
    {
    }

    public function sendMessages(MessageDTO $messageDTO): array
    {
        $result = [ProviderInterface::COUNT => 0, ProviderInterface::PRICE => 0];
        foreach ($this->messageSplitter->split($messageDTO) as $providerClass => $item) {
            try {
                $countAndPrice = $this->providerList->get($providerClass)->send($item->getPhones(), $item->getMessage());
                $result[ProviderInterface::COUNT] += $countAndPrice[ProviderInterface::COUNT];
                $result[ProviderInterface::PRICE] += $countAndPrice[ProviderInterface::PRICE];
            } catch (\Exception) {
                // log error
            }
        }

        return $result;
    }
}