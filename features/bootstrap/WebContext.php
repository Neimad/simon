<?php

namespace features\contexts\App;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

class WebContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response */
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Transform :uri
     */
    public function getPageUri(string $name): string
    {
        $uris = [
            'home' => '/',
            'foo' => '/foo',
        ];

        if (!isset($uris[$name])) {
            throw \InvalidArgumentException("Unknown URI for page '$name'");
        }

        return $uris[$name];
    }

    /**
     * @When a user requests the :uri page
     */
    public function requestPage(string $uri): void
    {
        $this->response = $this->kernel->handle(Request::create($uri), KernelInterface::MASTER_REQUEST, false);
    }

    /**
     * @Then he should receive a response
     */
    public function shouldReceiveResponse(): void
    {
        Assert::notNull($this->response);
    }
}
