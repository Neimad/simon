<?php

declare(strict_types=1);

namespace features\contexts\App;

use App\Document\DocumentInterface;
use App\Document\HomePage;
use App\Document\Page;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Webmozart\Assert\Assert;

class ModelContext implements Context
{
    /** @var DocumentManagerInterface */
    private $dm;

    private $id;

    public function __construct(DocumentManagerInterface $dm)
    {
        $this->dm = $dm;
    }

    /**
     * @BeforeSuite
     */
    public static function createWorkspace(): void
    {
        `bin/console doctrine:phpcr:workspace:create --ignore-existing testing`;
    }

    /**
     * @AfterSuite
     */
    public static function deleteWorkspace(): void
    {
        `bin/console doctrine:phpcr:workspace:create --ignore-existing testing`;
    }

    /**
     * @BeforeScenario
     */
    public function initWorkspace(): void
    {
        `bin/console doctrine:phpcr:repository:init --env=test`;
    }

    /**
     * @AfterScenario
     */
    public function cleanWorkspace(): void
    {
        `bin/console doctrine:phpcr:workspace:purge --force --env=test`;
    }

    /**
     * @When I requests the home page
     */
    public function requestsTheHomePage(): void
    {
        $repository = $this->dm->getRepository(HomePage::class);
        $page = $repository->find();

        $this->setDocument($page);
    }

    /**
     * @Given a page exists with title :title and content
     * @When I create a page with title :title and content
     */
    public function createPage(string $title, PyStringNode $content): void
    {
        $page = new Page();

        $page->setTitle($title)
            ->setContent((string) $content);

        $this->dm->persist($page);
        $this->dm->flush($page);

        $this->setDocument($page);
    }

    /**
     * @When I delete it
     */
    public function delete(): void
    {
        $document = $this->getDocument();

        $this->dm->remove($document);
        $this->dm->flush($document);
    }

    /**
     * @When I set its title to :title
     */
    public function setTitle(string $title)
    {
        $document = $this->getDocument();

        $document->setTitle($title);

        $this->dm->flush($document);
    }

    /**
     * @When I set its content to
     */
    public function setContent(PyStringNode $content)
    {
        $document = $this->getDocument();

        $document->setContent((string) $content);

        $this->dm->flush($document);
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
    public function shouldBeUnaivalable()
    {
        Assert::null($this->getDocument());
    }

    /**
     * @Then its title should be :title
     */
    public function shouldHaveTitle(string $title)
    {
        Assert::same($this->getDocument()->getTitle(), $title);
    }

    /**
     * @Then its content should be
     */
    public function shouldHaveContent(PyStringNode $content)
    {
        Assert::same($this->getDocument()->getContent(), (string) $content);
    }

    private function setDocument(DocumentInterface $document): void
    {
        $node = $this->dm->getNodeForDocument($document);

        $this->id = $node->getIdentifier();
    }

    private function getDocument(): ?DocumentInterface
    {
        if (null === $this->id) {
            return null;
        }

        return $this->dm->find(null, $this->id);
    }
}
