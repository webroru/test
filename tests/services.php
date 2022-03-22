<?php

declare(strict_types=1);

namespace tests\Meals;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $configurator) {

    $services = $configurator->services()
        ->defaults()
        ->public()
        ->autowire()
        ->autoconfigure()
    ;
};
