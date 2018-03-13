<?php

declare(strict_types=1);

namespace features\contexts\App;

use App\Document\DocumentInterface;
use App\Document\Page;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;

final class FixturesContext implements Context
{
    use WorkspaceTrait;

    /** @var DocumentManagerInterface */
    private $dm;

    /** @var array */
    private $identifiers = [];

    public function __construct(DocumentManagerInterface $dm)
    {
        $this->dm = $dm;
    }

    public function addFixture(DocumentInterface $document): void
    {
        $node = $this->dm->getNodeForDocument($document);

        $this->identifiers[] = $node->getIdentifier();
    }

    public function getFixture(): ?DocumentInterface
    {
        $id = \end($this->identifiers);

        if (null === $id) {
            return null;
        }

        return $this->dm->find(null, $id);
    }

    public function hasFixture(): bool
    {
        return null !== $this->getFixture();
    }

    /**
     * @Given a page exists with title :title and content
     * @Given a page exists with title :title
     */
    public function createPage(string $title, ?PyStringNode $content = null): void
    {
        $page = new Page();

        if (null === $content) {
            $content = "Content of page {$title}.";
        }

        $page->setTitle($title)
            ->setContent((string) $content);

        $this->dm->persist($page);
        $this->dm->flush($page);

        $this->addFixture($page);
    }
}
