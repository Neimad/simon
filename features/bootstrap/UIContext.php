<?php

declare(strict_types=1);

namespace features\contexts\App;

use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

final class UIContext extends AbstractDocumentContext
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response */
    private $response;

    public function __construct(KernelInterface $kernel, DocumentManagerInterface $dm)
    {
        $this->kernel = $kernel;

        parent::__construct($dm);
    }

    /**
     * @When I requests the home page
     */
    public function requestsTheHomePage(): void
    {
        $this->response = $this->kernel->handle(
            Request::create('/'),
            KernelInterface::MASTER_REQUEST,
            false
        );
    }

    /**
     * @When I create a page with title :title and content
     */
    public function createPage(string $title, PyStringNode $content): void
    {
        throw new PendingException();
    }

    /**
     * @When I delete it
     */
    public function delete(): void
    {
        throw new PendingException();
    }

    /**
     * @When I set its title to :title
     */
    public function setTitle(string $title): void
    {
        throw new PendingException();
    }

    /**
     * @When I set its content to
     */
    public function setContent(PyStringNode $content): void
    {
        throw new PendingException();
    }

    /**
     * @Then I should get it successfully
     * @Then it should be available
     */
    public function shouldBeAvailable(): void
    {
        Assert::same($this->response->getStatusCode(), Response::HTTP_OK);
    }

    /**
     * @Then it should be unaivalable
     */
    public function shouldBeUnavailable(): void
    {
        throw new PendingException();
    }

    /**
     * @Then its title should be :title
     */
    public function shouldHaveTitle(string $title): void
    {
        throw new PendingException();
    }

    /**
     * @Then its content should be
     */
    public function shouldHaveContent(PyStringNode $content): void
    {
        throw new PendingException();
    }
}
