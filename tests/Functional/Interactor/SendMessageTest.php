<?php

namespace tests\App\Functional\Interactor;

use PHPUnit\Framework\TestCase;
use tests\App\Functional\FunctionalTestCase;
use tests\Meals\Functional\Fake\Provider\FakeEmployeeProvider;

class SendMessageTest extends FunctionalTestCase
{
    public function testSuccessful()
    {
        $poll = $this->performTestMethod($this->getEmployeeWithPermissions(), $this->getPoll(true));
        verify($poll)->equals($poll);
    }

    private function performTestMethod($getEmployeeWithPermissions, $getPoll)
    {
        $this->getContainer()->get(FakeEmployeeProvider::class)->setEmployee($employee);
    }


}
