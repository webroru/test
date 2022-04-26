<?php

namespace App\Domain\Message;

use App\Domain\Provider\ProviderList;

class MessageSplitter
{
    public function __construct(
        private ProviderList $providerList,
    )
    {
    }

    /**
     * @param MessageDTO $messageDTO
     * @return MessageDTO[]
     */
    public function split(MessageDTO $messageDTO): array
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