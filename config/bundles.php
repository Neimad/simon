<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Symfony\Bundle\WebServerBundle\WebServerBundle::class => ['dev' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle::class => ['all' => true],
    Symfony\Cmf\Bundle\RoutingAutoBundle\CmfRoutingAutoBundle::class => ['all' => true],
    Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle::class => ['all' => true],
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class => ['dev' => true, 'test' => true],
    Neimad\SimonBundle\SimonBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle::class => ['dev' => true, 'test' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
];
