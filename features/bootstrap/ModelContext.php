<?php

declare(strict_types=1);

namespace features\contexts\App;

use App\Document\HomePage;
use Behat\Gherkin\Node\PyStringNode;
use Webmozart\Assert\Assert;

final class ModelContext extends AbstractDocumentContext
{
    /**
     * @When I requests the home page
     */
    public function requestsTheHomePage(): void
    {
        $dm = $this->getDocumentManager();
        $repository = $dm->getRepository(HomePage::class);
        $page = $repository->find();

        $this->setDocument($page);
    }

    /**
     * @When I create a page with title :title and content
     */
    public function createPage(string $title, PyStringNode $content): void
    {
        $this->pageExists($title, $content);
    }

    /**
     * @When I delete it
     */
    public function delete(): void
    {
        $dm = $this->getDocumentManager();
        $document = $this->getDocument();

        $dm->remove($document);
        $dm->flush($document);
    }

    /**
     * @When I set its title to :title
     */
    public function setTitle(string $title): void
    {
        $dm = $this->getDocumentManager();
        $document = $this->getDocument();

        $document->setTitle($title);

        $dm->flush($document);
    }

    /**
     * @When I set its content to
     */
    public function setContent(PyStringNode $content): void
    {
        $dm = $this->getDocumentManager();
        $document = $this->getDocument();

        $document->setContent((string) $content);

        $dm->flush($document);
    }

    /**
     * @Then I should get it successfully
     * @Then it should be available
     */
    public function shouldBeAvailable(): void
    {
        Assert::notNull($this->getDocument());
    }

    /**
     * @Then it should be unaivalable
     */
    public function shouldBeUnaivalable(): void
    {
        Assert::null($this->getDocument());
    }

    /**
     * @Then its title should be :title
     */
    public function shouldHaveTitle(string $title): void
    {
        $document = $this->getDocument();

        Assert::same($document->getTitle(), $title);
    }

    /**
     * @Then its content should be
     */
    public function shouldHaveContent(PyStringNode $content): void
    {
        $document = $this->getDocument();

        Assert::same($document->getContent(), (string) $content);
    }
}
