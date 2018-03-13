<?php

declare(strict_types=1);

namespace features\contexts\App;

use Behat\Behat\Context\Context;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractWebContext implements Context
{
    use FixturesAwareTrait;

    /** @var KernelInterface */
    private $kernel;

    /** @var Client */
    private $client;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function httpRequest(string $method, string $uri, array $parameters = []): Response
    {
        $client = $this->getClient();

        $client->request($method, $uri, $parameters);

        return $client->getResponse();
    }

    public function visit(string $uri): Response
    {
        return $this->httpRequest(Request::METHOD_GET, $uri);
    }

    public function crawlUri(string $uri): Crawler
    {
        return $this->getClient()->request(Request::METHOD_GET, $uri);
    }

    private function getClient(): Client
    {
        if (null === $this->client) {
            $this->client = $this->kernel->getContainer()->get('test.client');

            $this->client->catchExceptions(false);
        }

        return $this->client;
    }
}
