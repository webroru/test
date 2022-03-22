<?php

namespace App\Application\Feature\Send\UseCase\SendMessages;

use App\Domain\Message\MessageDTO;
use App\Domain\Provider\ProviderInterface;
use App\Domain\Provider\ProviderList;

class Interactor
{
    private array $messageDTOList = [];

    public function __construct(
        private ProviderList $providerList,
    )
    {
    }

    public function sendMessages(MessageDTO $messageDTO): array
    {
        $result = [ProviderInterface::COUNT => 0, ProviderInterface::PRICE => 0];
        foreach ($this->splitMessageDTO($messageDTO) as $providerClass => $item) {
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

    /**
     * @param MessageDTO $messageDTO
     * @return MessageDTO[]
     */
    private function splitMessageDTO(MessageDTO $messageDTO): array
    {
        $messageDTOList = [];
        foreach ($messageDTO->getPhones() as $phone) {
            try {
                $providers = $this->providerList->getByPrefix($this->getPrefix($phone));
                $provider = $this->providerList->sortByPrice($providers)[0];
                if (!isset($messageDTOList[$provider::class])) {
                    $messageDTOList[$provider::class] = new MessageDTO($messageDTO->getMessage());
                }
                $messageDTOList[$provider::class]->addPhone($phone);
            } catch (\Exception) {
                // log error
            }
        }

        return $messageDTOList;
    }

    private function getPrefix(string $phone): string
    {
        preg_match($phone, "/^(\+\d{2})/", $matches);
        if (!$matches[1]) {
            throw new \Exception('Wrong phone number');
        }

        return $matches[1];
    }
}