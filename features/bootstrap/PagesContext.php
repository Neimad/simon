<?php

declare(strict_types=1);

namespace features\contexts\App;

use App\Document\HomePage;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Webmozart\Assert\Assert;

final class PagesContext implements Context
{
    use FixturesAwareTrait;

    /** @var DocumentManagerInterface */
    private $dm;

    public function __construct(DocumentManagerInterface $dm)
    {
        $this->dm = $dm;
    }

    /**
     * @When I requests the home page
     */
    public function requestsTheHomePage(): void
    {
        $repository = $this->dm->getRepository(HomePage::class);
        $page = $repository->find();

        $this->getFixturesContext()->addFixture($page);
    }

    /**
     * @When I create a page with title :title and content
     */
    public function createPage(string $title, PyStringNode $content): void
    {
        $this->getFixturesContext()->createPage($title, $content);
    }

    /**
     * @When I delete it
     */
    public function delete(): void
    {
        $document = $this->getFixturesContext()->getFixture();

        $this->dm->remove($document);
        $this->dm->flush($document);
    }

    /**
     * @When I set its title to :title
     */
    public function setTitle(string $title): void
    {
        $document = $this->getFixturesContext()->getFixture();

        $document->setTitle($title);

        $this->dm->flush($document);
    }

    /**
     * @When I set its content to
     */
    public function setContent(PyStringNode $content): void
    {
        $document = $this->getFixturesContext()->getFixture();

        $document->setContent((string) $content);

        $this->dm->flush($document);
    }

    /**
     * @Then I should get it successfully
     * @Then it should be available
     */
    public function shouldBeAvailable(): void
    {
        Assert::true($this->getFixturesContext()->hasFixture());
    }

    /**
     * @Then it should be unavailable
     */
    public function shouldBeUnaivalable(): void
    {
        Assert::false($this->getFixturesContext()->hasFixture());
    }

    /**
     * @Then its title should be :title
     */
    public function shouldHaveTitle(string $title): void
    {
        $document = $this->getFixturesContext()->getFixture();

        Assert::same($document->getTitle(), $title);
    }

    /**
     * @Then its content should be
     */
    public function shouldHaveContent(PyStringNode $content): void
    {
        $document = $this->getFixturesContext()->getFixture();

        Assert::same($document->getContent(), (string) $content);
    }
}
