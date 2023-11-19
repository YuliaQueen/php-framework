<?php

use App\Providers\EventServiceProvider;
use League\Container\Container;
use Queendev\PhpFramework\Providers\ServiceProviderInterface;

$providers = [
    EventServiceProvider::class
];

foreach ($providers as $provider) {
    /** @var Container $container */
    $provider = $container->get($provider);

    /** @var ServiceProviderInterface $provider */
    $provider->register();
}